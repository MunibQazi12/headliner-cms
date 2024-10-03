<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChooseForDryIce;
use App\Models\DistributionCenter;
use App\Models\Industry;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends BaseController
{
    /**
     * @OA\Get(
     * path="/api/category-list",
     * operationId="Category list",
     * tags={"Home Management"},
     * summary="Category list Fetch",
     * description="Get Category list ",
     *      @OA\Response(
     *          response=201,
     *          description="Category list retrieve Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function categoryList()
    {
        $category = Category::where('active', 1)->get();
        if ($category->isNotEmpty()) {
            return $this->sendResponse($category, 'Categories list retrieved successfully.');
        } else {
            return $this->sendError('No category found.', [], 404);
        }
    }

    /**
     * @OA\Get(
     * path="/api/industry-list",
     * operationId="Industry list",
     * tags={"Home Management"},
     * summary="Industry list Fetch",
     * description="Get Industry list ",
     *      @OA\Response(
     *          response=201,
     *          description="Industry list retrieve Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function industryList()
    {
        $industry = Industry::where('status', 1)->get();
        if ($industry->isNotEmpty()) {
            return $this->sendResponse($industry, 'Industries list retrieved successfully.');
        } else {
            return $this->sendError('No industry found.', [], 404);
        }
    }


    /**
     * @OA\Get(
     * path="/api/choose-for-list",
     * operationId="Choose for list",
     * tags={"Home Management"},
     * summary="Choose for list Fetch",
     * description="Get Choose for list ",
     *      @OA\Response(
     *          response=201,
     *          description="Choose for list retrieve Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function chooseForList()
    {
        $choosefor = ChooseForDryIce::where('status', 1)->get();
        if ($choosefor->isNotEmpty()) {
            return $this->sendResponse($choosefor, 'Choose For list retrieved successfully.');
        } else {
            return $this->sendError('No choose for found.', [], 404);
        }
    }
    /**
     * @OA\Get(
     * path="/api/testimonials",
     * operationId="Testimonial list",
     * tags={"Home Management"},
     * summary="Testimonial list Fetch",
     * description="Get Testimonial list ",
     *      @OA\Response(
     *          response=201,
     *          description="Testimonial list retrieve Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function testimonialList()
    {
        $testimonial = Testimonial::all();
        if ($testimonial->isNotEmpty()) {
            return $this->sendResponse($testimonial, 'Testimonial list retrieved successfully.');
        } else {
            return $this->sendError('No testimonial found.', [], 404);
        }
    }

     /**
     * @OA\Get(
     * path="/api/distribution-center-list",
     * operationId="Distribution Center list",
     * tags={"Home Management"},
     * summary="Distribution Center list Fetch",
     * description="Get Distribution Center list ",
     *      @OA\Response(
     *          response=201,
     *          description="Distribution Center list retrieve Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function distributionList(){
        $distribution = DistributionCenter::where('status', 1)->get();
        if ($distribution->isNotEmpty()) {
            return $this->sendResponse($distribution, 'Distribution center retrieved successfully.');
        } else {
            return $this->sendError('No distribution center found.', [], 404);
        }
    }

    /**
     * @OA\Get(
     * path="/api/home-page",
     * operationId="home-page",
     * tags={"Home Management"},
     * summary="Home Page",
     * description="Home Page ",
     *      @OA\Response(
     *          response=201,
     *          description="data fetched",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function homePage()
    {
        try {
            $data['industry'] = $this->industryList();
            $data['category'] = $this->categoryList();
            $data['choosefor'] = $this->chooseForList();
            $data['testimonial'] = $this->testimonialList();
            if($data){
                return $this->sendResponse($data, 'home page fetched', 201);
            }else{
                return $this->sendError('No pages found.', [], 404);  
            }
          
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
            return $this->sendError([], 'Something went wrong', 500);
        }
    }

}
