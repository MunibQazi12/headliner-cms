<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\SEOFAQ;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;


class SeoController extends Controller
{
    public function index(Request $request)
    {

        try {

            $seopages = SeoSetting::query();


            if ($request->name) {
                $seopages = $seopages->where('meta_title', 'LIKE', '%' . $request->name . '%');
            }

            $locations = [];
            $longitudes = [];
            $latitudes = [];
            
            if($request->locations){
                $seopages = $seopages->whereIn('state', $request->locations);
            }
            
            if ($request->distance && $request->filteredCoordinates) {
                $distance = $request->distance;
                
                foreach ($request->filteredCoordinates as $coordinate) {
                    $arr = explode('|', $coordinate);
                    Log::info($arr);
                    
                    if (count($arr) === 3) { 
                        $cityName = $arr[0];   // City name (if needed for later use)
                        $latitude = $arr[1];   // Latitude
                        $longitude = $arr[2];  // Longitude
            
                        // Apply Haversine formula for distance filtering
                        $seopages->orWhereRaw("
                            (3959 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) < ?
                        ", [
                            $latitude,         
                            $longitude,         
                            $latitude,         
                            $distance           
                        ]);
                    }
                }
            }

            $perPage = $request->perPage ?? 20;

            $seopages = $seopages
                ->orderBy('id', 'desc')
                ->paginate($perPage)
                ->withQueryString();
            
    
            $locationsSelected = $request->locations;
            $distanceSelected = $request->distance;
            return Inertia::render('Admin/seo/List', compact('seopages' , 'locationsSelected', 'distanceSelected' ));
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
        }
    }

    public function changeSeoStatus(Request $request)
    {
        $arr = explode(",", strval($request->id));
        
        for($i=0; $i<count($arr); $i++) {
            $id = $arr[$i];
            $product = SeoSetting::find($id);
            try {
                // toggle status in case of single product
                $status = !$product->status;
                if( isset($request->action) ) {
                    // change status based on request action in case of bulk updation.
                    $status = $request->action =='Unpublish' ? false : true;    
                }
                $product->status = $status;
                $product->save();
            } catch (\Throwable $th) {
                Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
                abort(500);
            }
        }
        session()->flash('success', 'Product status successfully changed');
        return back();
    }


    public function deleteSeo(Request $request, $id)
    {
        try {
            $resource = SeoSetting::findOrfail($id);
            $resource->delete();
            session()->flash('success', 'Resource successfully deleted');
            return redirect()->back();
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
        }
    }

    public function createSeo(Request $request)
    {
      
        if ($request->isMethod('POST')) {
            
            $credentials = $request->validate([
                'meta_title' => 'required',
                'meta_description' => 'required',
                'faqs' => 'required|array',
                'faqs.*.question' => 'required',
                'faqs.*.answer' => 'required',
            ]);
            try {
             
                $resource = new SeoSetting();
                $resource->meta_title = $request->meta_title;
                $resource->slug = $request->slug;
                $resource->meta_description = $request->meta_description;
                $resource->h1_tag = $request->h1_tag;
                $resource->h2_tag = $request->h2_tag;
                $resource->status = $request->status;
                $resource->p_tag = $request->p_tag;
                $resource->city = $request->city;
                $resource->state = $request->state;
                $resource->state_code = $request->state_code;
                $resource->zip_codes = $request->zip_codes;
                $resource->type = $request->type;
                $resource->latitude = $request->latitude;
                $resource->longitude = $request->longitude;
                $resource->save();
                if ($request->faqs[0]['question'] != null) {
                    foreach ($request->faqs as $k) {
                        $faq = new SEOFAQ;
                        $faq->slug = $request->slug;
                        $faq->question = $k['question'];
                        $faq->answer = $k['answer'];
                        $faq->save();
                    }
                }
                session()->flash('success', 'Seo page successfully added');
                return redirect()->route('admin.seo.pages');
            } catch (\Throwable $th) {
                Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
                abort(500);
            }
        }
        return Inertia::render('Admin/seo/CreateEdit');
    }

    public function editSeo(Request $request, $slug)
    {
        try {
            $seo = SeoSetting::where('slug', $slug)->first();
            $faq = SEOFAQ::where("slug" , $slug)->get();
            return Inertia::render('Admin/seo/CreateEdit', compact('seo' ,'faq'));
        } catch (\Exception $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }

    public function updateSeo(Request $request, $slug)
    {
        $seo = SeoSetting::where('slug', $slug)->first();
        $faq = SEOFAQ::where('slug', $slug)->get();

        $credentials = $request->validate([
            'meta_title' => 'required',
            'meta_description' => 'required',
            'faqs' => 'required|array',
            'faqs.*.question' => 'required',
            'faqs.*.answer' => 'required',
        ]);

        Log::error($seo);
        Log::error($slug);

        try {
            $seo->meta_title = $request->meta_title;
            $seo->slug = $request->slug;
            $seo->meta_description = $request->meta_description;
            $seo->h1_tag = $request->h1_tag;
            $seo->h2_tag = $request->h2_tag;
            $seo->status = $request->status;
            $seo->p_tag = $request->p_tag;
            $seo->city = $request->city;
            $seo->state = $request->state;
            $seo->state_code = $request->state_code;
            $seo->zip_codes = $request->zip_codes;
            $seo->type = $request->type;
            $seo->latitude = $request->latitude;
            $seo->longitude = $request->longitude;

            $seo->save();
            SEOFAQ::where('slug', $slug)->delete();
                if ($request->faqs[0]['question'] != null) {
                    foreach ($request->faqs as $k) {
                        $faq = new SEOFAQ;
                        $faq->slug = $slug;
                        $faq->question = $k['question'];
                        $faq->answer = $k['answer'];
                        $faq->save();
                    }
                }
            // if ($request->product_attr) {
            //     foreach ($request->schema as $value) {
            //         $product_attr = new ProductAttribut;
            //         $product_attr->product_id = $product->id;
            //         $product_attr->size = $value['size'];
            //         $product_attr->details = $value['dtls'];
            //         $product_attr->price = $value['price'];
            //         $product_attr->save();
            //     }
            // }
            session()->flash('success', 'Successfully updated');
            return redirect()->route('admin.seo.pages');
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
        }
    }
}
