<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DistributionCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class DistributorController extends BaseController
{
    public function index()
    {
        try {
            $distributions = DistributionCenter::get();

            return $this->sendResponse($distributions, 'data fetched', 201);
        } catch (\Exception $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }
}
