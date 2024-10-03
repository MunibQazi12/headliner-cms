<?php

namespace App\Http\Controllers\API;

use App\Models\DistributionCenter;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductAttribut;
use App\Models\SeoSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Stripe\Stripe as StripeGateway;

class OrderController extends BaseController
{
    public function index()
    {
        try {
            $orders = Order::where('user_id', Auth::id())->with('order_item', 'order_item.product', 'order_item.product_attribute')->get();

            return $this->sendResponse($orders, 'data fetched', 201);
        } catch (\Exception $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }

    public function completePayment(Request $request)
    {
        try {
            $location_id = $request->dest;
            $coordinates = $this->getCoordinatesFromLocationId($location_id);

            if (!$coordinates) {
                return response()->json(['error' => 'Location not found'], 404);
            }

            $destination_lat = $coordinates['lat'];
            $destination_lng = $coordinates['lng'];

            $agency = DistributionCenter::where('id', $request->agency_id)->first();

            if (!$agency) {
                return response()->json(['error' => 'No agency found'], 404);
            }

            $origins = [];
            $origins[] = "{$agency->latitude},{$agency->longitude}";

            $distances = $this->getDistancesFromGoogleMaps($origins, "{$destination_lat},{$destination_lng}");
            if (!$distances) {
                return response()->json(['error' => 'Failed to retrieve distances'], 500);
            }

            $quantity = 0;
            $price = 0;
            foreach ($request->items as $item) {
                $quantity += $item['qty'];
                $product = ProductAttribut::where('id', $item['attribute']['id'])->first();
                $price += $product->price * $item['qty'];
            }
            $fee = $this->calculateFee($distances[0] * 0.000621371, $quantity);
            $price += $fee;

            $user = null;
            Stripe::setApiKey(config('services.stripe.secret'));
            if ($request->billing_details) {
                $email = $request->billing_details['email'];
                $name = $request->billing_details['name'];
                $user = User::role('USER')->where('email', $email)->first();
                if (!$user) {
                    DB::beginTransaction();
                    try {

                        $inputs['active'] = 1;

                        $customer = Customer::create([
                            'email' => $email,
                            'name' => $name,
                        ]);
                        $inputs['first_name'] = $name;
                        $inputs['last_name'] = " ";
                        $inputs['email'] = $email;

                        $inputs['customer_id'] = $customer->id;
                        $inputs['password'] = bcrypt($request->email);
                        $user = User::create($inputs);
                        $user->assignRole('USER');
                        DB::commit();
                        $user = User::find($user->id);

                    } catch (\Throwable $th) {
                        DB::rollBack();
                        Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString() . "\n" . $th->getFile() . "\n" . $th->getLine());
                        return $this->sendError('Server Error!', [], 500);
                    }
                }

                if ($request->payment_method_id) {
                

                    

                    // Detach the old payment method if it exists
                    if ($user->payment_method_id) {
                        $oldPaymentMethod = PaymentMethod::retrieve($user->payment_method_id);
                        $oldPaymentMethod->detach();
                    }

                    // Attach the new payment method
                    $paymentMethod = PaymentMethod::retrieve($request->payment_method_id);
                    $paymentMethod->attach(['customer' => $user->customer_id]);

                    \Stripe\Customer::update(
                        $user->customer_id,
                        [
                            'invoice_settings' => [
                                'default_payment_method' => $request->payment_method_id,
                            ],
                        ]
                    );

                    $user->payment_method_id = $request->payment_method_id;

                    $user->save();
                }
            }
            Log::error($user);

            if (!$user->payment_method_id) {
                return response()->json(['error' => 'No Payment Method'], 400);
            }

           

            $paymentIntent = PaymentIntent::create([
                'customer' => $user->customer_id,
                'amount' => $price * 100,
                'currency' => 'usd',
                'payment_method' => $user->payment_method_id,
                'off_session' => true,
                'confirm' => true,
            ]);

            // Check the status of the payment intent
            if ($paymentIntent->status == 'succeeded') {
                $price = 0;
                foreach ($request->items as $item) {
                    $quantity += $item['qty'];
                    $product = ProductAttribut::where('id', $item['attribute']['id'])->first();
                    $price += $product->price * $item['qty'];
                }
                $order = Order::create([
                    'user_id' => $user->id,

                    'shipping_charge' => $fee,
                    'amount' => $price,
                    'agency_id' => $request->agency_id,
                    'address' => $location_id,
                ]);
                foreach ($request->items as $item) {
                    $quantity += $item['qty'];
                    $product = ProductAttribut::where('id', $item['attribute']['id'])->first();
                    OrderItem::create([
                        "order_id" => $order->id,
                        'product_id' => $product->product_id,
                        'product_attr_id' => $product->id,
                        'quantity' => $item['qty'],
                        'price' => $item['qty'] * $product->price,
                    ]);
                }

                // Payment was successful
                return response()->json([
                    'success' => true,
                    'message' => 'Payment successful!',
                    'data' => $order,
                ]);
            } else {
                // Payment requires additional actions
                return response()->json([
                    'success' => false,
                    'payment_intent' => $paymentIntent,
                ]);
            }

            return $this->sendResponse('$address', 'data fetched', 201);
        } catch (\Exception $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }

    private function getCoordinatesFromLocationId($location_id)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $response = Http::get("https://maps.googleapis.com/maps/api/place/details/json", [
            'place_id' => $location_id,
            'key' => $apiKey,
        ]);

        if ($response->successful() && isset($response['result']['geometry']['location'])) {
            return $response['result']['geometry']['location'];
        }

        return null;
    }

    private function getDistancesFromGoogleMaps($origins, $destination)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $originsStr = implode('|', $origins);
        $response = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json", [
            'origins' => $originsStr,
            'destinations' => $destination,
            'key' => $apiKey,
        ]);

        if ($response->successful() && isset($response['rows'])) {
            $distances = [];
            foreach ($response['rows'] as $row) {
                $distances[] = $row['elements'][0]['distance']['value'];
            }
            return $distances;
        }

        return null;
    }

    private function calculateFee($distance, $quantity)
    {
        // Define the minimum order thresholds
        $minimumOrders = [
            [0, 50, 50],
            [51, 100, 200],
            [101, 200, 500],
            [201, 100000, 1000],
        ];

        // Define the fees for the ranges
        $fees = [
            [51, 100, 100],
            [101, 150, 200],
            [151, 200, 250],
            [201, 250, 300],
            [251, 100000, 350],
        ];

        // Check for free shipping
        foreach ($minimumOrders as $range) {
            list($minDistance, $maxDistance, $minOrder) = $range;
            if ($distance >= $minDistance && $distance <= $maxDistance) {
                if ($quantity >= $minOrder) {
                    return 0; // Free shipping
                }
            }
        }

        // Calculate the fee if not eligible for free shipping
        foreach ($fees as $range) {
            list($minDistance, $maxDistance, $fee) = $range;
            if ($distance >= $minDistance && $distance <= $maxDistance) {
                return $fee;
            }
        }

        // Return -1 if distance is out of range
        return -1;
    }
}
