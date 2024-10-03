<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ResourceController extends BaseController
{

        /**
     * @OA\Get(
     * path="/api/resources",
     * operationId="Resources",
     * tags={"Resource Management"},
     * summary="Resource Management",
     * description=" Get all resource",
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
    public function resources()
    {
        $resources = Resource::all();
        try {
            return $this->sendResponse($resources, 'data fetched', 201);
        } catch (\Throwable $th) {
            return $this->sendError([],'Something Wrong',500);
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
        }
    }

         /**
     * @OA\Get(
     * path="/api/resource/{id}/details",
     * operationId="Resource",
     * tags={"Resource Management"},
     * summary="Get details of particular resource",
     * description="Get Get details of particular resource",
     *      @OA\Parameter(
     *          name="id",
     *          description="resource id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Details fetched",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=404, description="Not found"),
     * )
     */
    public function resourceDtls($slug)
    {
        try {
            $resource = Resource::where("slug" , $slug)->get()->first();
            $others=Resource::where("slug","!=" , $slug)->take(3)->latest()->get();
            return $this->sendResponse(["resource" => $resource,"other" => $others], 'data fetched', 201);
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
            return $this->sendError([],'Not Found',201);
        }
    }
}
