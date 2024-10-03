<?php

namespace App\Http\Controllers\API;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;




class AddressController extends BaseController
{
    public function index()
    {
        try {
            $address = Address::where('user_id', Auth::id())->get();

            return $this->sendResponse($address, 'data fetched', 201);
        } catch (\Exception $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }
    public function store(Request $request)
    {
        try {
            $address = new Address;
            $address->user_id = Auth::id();
            $address->place_id = $request->place_id;
            $address->formatted_address = $request->formatted_address;

            $address->save();

            return $this->sendResponse($address, 'data fetched', 201);
        } catch (\Exception $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }
}
