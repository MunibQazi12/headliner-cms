<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FooterSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FooterSettingsController extends BaseController
{
    public function footerSettings(Request $request)
    {
        $footer_settings = FooterSettings::all();
        try {
            return $this->sendResponse($footer_settings, 'data fetched', 201);
        } catch (\Throwable $th) {
            return $this->sendError([],'Something Wrong',500);
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
        }
    }
}
