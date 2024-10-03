<?php

namespace App\Http\Controllers\API;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\SEOFAQ;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;




class SeoController extends BaseController
{
    public function getSeoPage($slug)
    {
        try {
            $seo = SeoSetting::where('slug', $slug)->where("status" , 1)->first();
            $faq = SEOFAQ::where('slug', $slug)->get();
            return $this->sendResponse(["seo" => $seo , "faq" => $faq], 'data fetched', 201);
        } catch (\Exception $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }
    public function getSeoPages()
    {
        try {
            $seo = SeoSetting::where("status" , 1)->get();

            return $this->sendResponse($seo, 'data fetched', 201);
        } catch (\Exception $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }
}
