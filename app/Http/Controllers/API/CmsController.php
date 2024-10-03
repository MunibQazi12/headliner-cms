<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Cms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Faq;

class CmsController extends BaseController
{
    /**
     * @OA\Get(
     * path="/api/get/{slug}/cms",
     * operationId="Api Cms Management",
     * tags={"Cms Management"},
     * summary="Get cms pages by slug",
     * description="Get cms pages by slug",
     *      @OA\Parameter(
     *          name="slug",
     *          description="cms slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Page fetched",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=404, description="Not found"),
     * )
     */
    public function getCmsPage($slug)
    {
        try {
            $pages = Cms::where('slug', $slug)->get();
            if ($pages->isNotEmpty()) {
                return $this->sendResponse($pages, 'data fetched', 201);
            }
            return $this->sendResponse($pages, 'No Data Found', 201);
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
            return $this->sendError([], 'Something went wrong', 500);
        }
    }


    /**
     * @OA\Get(
     * path="/api/get-faq",
     * operationId="Faq",
     * tags={"Cms Management"},
     * summary="Api For Get Faq",
     * description="Api For Get Faq",
     *      @OA\Response(
     *          response=200,
     *          description="Data fetched",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent()
     *       ),
     * )
     */

    public function getFaq()
    {
        try {
            $faq = Faq::where('active', 1)->get();
            if ($faq->isNotEmpty()) {
                return $this->sendResponse($faq, 'data fetched', 201);
            }
            return $this->sendResponse([], 'No data available', 201);
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
            return $this->sendError([], 'Something went wrong', 500);
        }
    }

       /**
     * @OA\Get(
     * path="/api/dry-ice-page",
     * operationId="dry-ice-page",
     * tags={"Cms Management"},
     * summary="Api Dry_ice page",
     * description="Api for  Dry_ice page",
     *      @OA\Response(
     *          response=200,
     *          description="Data fetched",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent()
     *       ),
     * )
     */
    public function dryIcePage()
    {
    
        try {
            $category = Category::where('active', 1)->get();
            if ($category->isNotEmpty()) {
                $data['category'] = $category;
            } else {
                $category = null;
            }
            $data['faq'] = $this->getFaq();
             
            return $this->sendResponse($data,'data fetched');
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
            return $this->sendError([], 'Something went wrong');
        }
    }

}
