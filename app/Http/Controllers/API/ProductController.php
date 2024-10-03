<?php

namespace App\Http\Controllers\API;

use App\Models\ContactUs;
use App\Models\CustomCutDryice;
use App\Models\DistributionCenter;
use App\Models\ProductFaq;
use App\Models\ProductShippings;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribut;
use Illuminate\Support\Facades\Log;
use App\Models\SeoSetting;
use Illuminate\Support\Facades\Validator;



class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        $products = Product::query();
        if ($request->name) {
            $products = $products->where('name', 'like', '%' . trim(addslashes($request->name) . '%'));
        }

        if (isset($request->active)) {
            $products = $products->where('status', $request->active);
        }

        if ($request->fieldName && $request->shortBy) {
            $products->orderBy($request->fieldName, $request->shortBy);
        }

        $perPage = $request->perPage ?? 20;

        $products = $products
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return response()->json([
            'data' => $products,
            'message' => 'Data fetched successfully',
        ], 200);
    }

    public function getProduct($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $product_attributes = ProductAttribut::where('product_id', $product->id)->get();
        $product_shipping = ProductShippings::where('product_id', $product->id)->get();
        $faq = ProductFaq::where('product_id', $product->id)->get();

        return response()->json([
            'product' => $product,
            'product_attribute' => $product_attributes,
            'product_shipping' => $product_shipping,
            'faq' => $faq,
            'message' => 'Data fetched successfully',
        ], 200);
    }

    public function customCutDryiceRequest(Request $request){
        $rules = [
            'name' => 'required',
            'email' =>  'required|max:255',
            'requirement'  =>  'required',
        ];

      

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validator->errors()->first()]);
        }
        $name = $request->name;
        $email = $request->email;
        $requirement = $request->requirement;

        CustomCutDryice::create([
            "name" => $name,
            "email" => $email,
            "requirement" => $requirement,
        ]);
        return response()->json(["success" => true, "code" => 200, "message" => "requirement sent successfully"]);
    }
    public function contactUs(Request $request){
        $rules = [
            'full_name' => 'required',
            'email' =>  'required|max:255',
            'phone' =>  'required|max:255',
            'address' =>  'required|max:255',
            'message'  =>  'required',
        ];

      

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(["success" => false, "code" => 550, "message" => $validator->errors()->first()]);
        }
        $name = $request->full_name;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;
        $message = $request->message;

        ContactUs::create([
            "full_name" => $name,
            "email" => $email,
            "phone" => $phone,
            "delivery_address" => $address,
            "message" => $message,
        ]);
        return response()->json(["success" => true, "code" => 200, "message" => "requirement sent successfully"]);
    }

    public function getDistance(Request $request)
    {
        $location_id = $request->location;
        $coordinates = $this->getCoordinatesFromLocationId($location_id);

        if (!$coordinates) {
            return response()->json(['error' => 'Location not found'], 404);
        }

        $destination_lat = $coordinates['lat'];
        $destination_lng = $coordinates['lng'];

        $agencies = DistributionCenter::all();

        if ($agencies->isEmpty()) {
            return response()->json(['error' => 'No agencies found'], 404);
        }

        $origins = [];
        foreach ($agencies as $agency) {
            $origins[] = "{$agency->latitude},{$agency->longitude}";
        }

        $distances = $this->getDistancesFromGoogleMaps($origins, "{$destination_lat},{$destination_lng}");
        if (!$distances) {
            return response()->json(['error' => 'Failed to retrieve distances'], 500);
        }

        // Step 3: Find the Nearest Agency Based on Route Distance
        $nearestAgency = null;
        $minDistance = PHP_INT_MAX;

        foreach ($agencies as $index => $agency) {
            if ($distances[$index] !== null) {
                $distance = $distances[$index];

                if ($distance < $minDistance) {
                    $minDistance = $distance;
                    $nearestAgency = $agency;
                }
            }
        }

        if (!$nearestAgency) {
            return response()->json(['error' => 'No agencies found'], 404);
        }

        return response()->json([
            'agency' => $nearestAgency,
            'destination' => $coordinates,
            'origination' => [
                'lat' => $nearestAgency->latitude,
                'lng' => $nearestAgency->longitude
            ],
        ]);
    }

    private function getCoordinatesFromLocationId($location_id)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $response = Http::get("https://maps.googleapis.com/maps/api/place/details/json", [
            'place_id' => $location_id,
            'key' => $apiKey
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
            'key' => $apiKey
        ]);

        if ($response->successful() && isset($response['rows'])) {
            $distances = [];
            foreach ($response['rows'] as $row) {
                if (
                    $row['elements'][0]['status'] === 'OK'
                ) {
                    $distances[] = $row['elements'][0]['distance']['value'];
                } else {
                    $distances[] = null;
                }
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
