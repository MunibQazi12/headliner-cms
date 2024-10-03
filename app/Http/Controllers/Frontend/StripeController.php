<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe as StripeGateway;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\StripeClient;
use Illuminate\Support\Str;
use Stripe\PaymentMethod;

class StripeController extends Controller
{
    public function stripeView()
    {
        try {
            return inertia('Frontend/StripePage');
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
        }
    }

    public function initiatePayment(Request $request)
    {
        StripeGateway::setApiKey('sk_test_51PUlYXP0cyYM8ORhkrBSbIh2pzNLw7FQURwP5rfDOsV4QX4dCzaV9Xm4QMFfl9sK5QashmDCwDtqFVvx47j5gMWE008I6LH8Ww');
        Log::info("Initiating payment with request data:", $request->all());
        try {
            // Validate the request
            $request->validate([
                'amount' => 'required|numeric|min:1',
                'currency' => 'required|string',
            ]);

            // Create a customer
            $customer_create = Customer::create([
                'name' => 'Jenny Rosen',
                'email' => 'jennyrosen@example.com',
            ]);

            // Create a payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, // Amount should be in cents
                'currency' => $request->currency,
                'customer' => $customer_create->id,
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'description' => 'First stripe payment',
                'shipping' => [
                    'name' => "Ranom singh",
                    'address' => [
                        'line1' => "510 Townsend St",
                        'postal_code' => "98140",
                        'city' => "San Francisco",
                        'state' => "CA",
                        'country' => "US",
                    ],
                ],
            ]);

            return response()->json(['token' => (string) Str::uuid(), 'paymentIntentId' => $paymentIntent->id, 'client_secret' => $paymentIntent->client_secret]);
        } catch (\Exception $e) {
            // Log the exception
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Log Stripe specific exceptions
            Log::error(" :: STRIPE API EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['error' => 'Stripe API Error', 'message' => $e->getMessage()], 500);
        } catch (\Throwable $th) {
            // Log any other throwable
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            return response()->json(['error' => 'Internal Server Error', 'message' => $th->getMessage()], 500);
        }
    }

    public function completePayment(Request $request)
    {
        try {

            $stripe = new StripeClient('sk_test_51PUlYXP0cyYM8ORhkrBSbIh2pzNLw7FQURwP5rfDOsV4QX4dCzaV9Xm4QMFfl9sK5QashmDCwDtqFVvx47j5gMWE008I6LH8Ww');

            // Use the payment intent ID stored when initiating payment
            $paymentDetail = $stripe->paymentIntents->retrieve($request->paymentIntentId);

            if ($paymentDetail->status != 'succeeded') {
                return response()->json("Something Went Wrong");
            }
            return response()->json("Success");
            // Complete the payment
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
        }
    }

    public function failPayment(Request $request)
    {
        try {
            // Log the failed payment if you wish
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
        }
    }

    public function getPaymentMethod()
    {
        try {
            StripeGateway::setApiKey(config('services.stripe.secret'));

            $user = User::where('id', Auth::id())->select('id', 'payment_method_id', 'customer_id')->first();

            if ($user->payment_method_id) {
                $paymentMethod = PaymentMethod::retrieve($user->payment_method_id);

                return response()->json([
                    'id' => $paymentMethod->id,
                    'card' => [
                        'brand' => $paymentMethod->card->brand,
                        'last4' => $paymentMethod->card->last4,
                        'exp_month' => $paymentMethod->card->exp_month,
                        'exp_year' => $paymentMethod->card->exp_year,
                    ],
                    'billing_details' => $paymentMethod->billing_details,
                ]);
            }

            return response()->json(null);
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
        }
    }

    public function updatePaymentMethod(Request $request)
    {
        try {
            StripeGateway::setApiKey(config('services.stripe.secret'));

            $user = User::where('id', Auth::id())->select('id', 'payment_method_id', 'customer_id')->first();

            if (!$request->payment_method_id) {
                return response()->json(['message' => 'No payment method provided'], 400);
            }

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
            Log::error($request);

            return response()->json(['message' => 'Payment method saved successfully']);
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
        }
    }
}
