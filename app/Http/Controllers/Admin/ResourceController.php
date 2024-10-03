<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ResourceController extends Controller
{


    public function resourceList(Request $request)
    {
        $resources = Resource::query();
        if ($request->title) {
            $resources = $resources->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->created_at) {
            $resources = $resources->where('title', 'like', '%' . $request->created_at . '%');
        }
        if ($request->slug) {
            $resources = $resources->where('slug', 'like', '%' . $request->slug . '%');
        }
        if (isset($request->status)) {
            $resources = $resources->where('status', $request->status);
        }

        if ($request->fieldName && $request->shortBy) {
            $resources->orderBy($request->fieldName, $request->shortBy);
        }

        $perPage = $request->perPage ?? 20;

        $resources = $resources
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Admin/resource/List', ['resources' => $resources]);
    }

    public function createResource(Request $request)
    {
        Log::error($request);
        if ($request->isMethod('POST')) {
            $validateData = $request->validate([
                'title' => ['required'],
                'resource_desc' => ['required'],
                'thumbnail' => ['required', 'mimes:png,jpg', 'max:2048'],
                'slug' => ['required', 'max:255'],
                'status' => ['required'],
                'meta_title' => ['nullable', 'max:500'],
                'h1' => ['nullable', 'max:225'],
                'meta_description' => ['nullable', 'max:500'],
                'open_graph_title' => ['nullable', 'max:500'],
                'open_graph_description' => ['nullable', 'max:500'],
                'open_graph_url' => ['nullable', 'url'],
                'photo' => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'featured_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'x_card_title' => ['nullable', 'max:500'],
                'x_card_description' => ['nullable', 'max:500']
            ], [
                'thumbnail.max' => 'The thumbnail size should be less than 2MB',
                'open_graph_image.max' => 'The thumbnail size should be less than 2MB'
            ]);
            try {
                $resource = new Resource;
                $resource->title = $request->title;
                $resource->slug = $request->slug;
                $resource->status = $request->status;
                $resource->h1 = $request->h1;
                $resource->meta_title = $request->meta_title;
                $resource->meta_description = $request->meta_description;
                $resource->open_graph_title = $request->open_graph_title;
                $resource->open_graph_description = $request->open_graph_description;
                $resource->open_graph_url = $request->open_graph_url;
                $resource->x_card_title = $request->x_card_title;
                $resource->x_card_description = $request->x_card_description;
                $resource->resource_desc = $request->resource_desc;
                if ($request->hasFile('thumbnail')) {
                    $file = $request->file('thumbnail');
                    $path = 'resource_thumbnail';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $resource->thumbnail = $final_image_url;
                }
                if ($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $path = 'open_graph_image';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $resource->open_graph_image = $final_image_url;
                }
                if ($request->hasFile('featured_image')) {
                    $file = $request->file('featured_image');
                    $path = 'seo_featured_image';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $resource->featured_image = $final_image_url;
                }

                // $resource->save();
                $resource->save();
                Log::error("@@@");
                session()->flash('success', 'Resource successfully added');
                return redirect()->route('admin.resource-list');
            } catch (\Throwable $th) {
                Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
                abort(500);
            }
        }
        return Inertia::render('Admin/resource/CreateEdit');
    }

    public function editResource(Request $request, $id)
    {
        $resource = Resource::findOrfail($id);
        $prev_picture = $resource->thumbnail;
        $prev_picture2 = $resource->open_graph_image;
        $prev_feature_image = $resource->featured_image;

        if ($request->isMethod('post')) {
            // dd($request->all());
            $validateData = $request->validate([
                'title' => ['required'],
                'resource_desc' => ['required'],
                'thumbnail' => $request->hasFile('thumbnail') ? 'mimes:jpeg,png,jpg|max:2048' : '',
                'slug' => ['required', 'max:255'],
                'status' => ['required'],
                'h1' => ['nullable', 'max:225'],
                'meta_title' => ['nullable', 'max:500'],
                'meta_description' => ['nullable', 'max:500'],
                'open_graph_title' => ['nullable', 'max:500'],
                'open_graph_description' => ['nullable', 'max:500'],
                'open_graph_url' => ['nullable', 'url'],
                'photo' => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'featured_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'x_card_title' => ['nullable', 'max:500'],
                'x_card_description' => ['nullable', 'max:500']
            ], [
                'thumbnail.max' => 'The thumbnail size should be less than 2MB',

            ]);
            try {
                $resource->title = $request->title;
                $resource->slug = $request->slug;
                $resource->status = $request->status;
                $resource->h1 = $request->h1;
                $resource->meta_title = $request->meta_title;
                $resource->meta_description = $request->meta_description;
                $resource->open_graph_title = $request->open_graph_title;
                $resource->open_graph_description = $request->open_graph_description;
                $resource->open_graph_url = $request->open_graph_url;
                $resource->x_card_title = $request->x_card_title;
                $resource->x_card_description = $request->x_card_description;
                $resource->resource_desc = $request->resource_desc;
                if ($request->hasFile('thumbnail')) {
                    if (file_exists($prev_picture)) {
                        @unlink($prev_picture);
                    }
                    $file = $request->file('thumbnail');
                    $path = 'resource_thumbnail';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $resource->thumbnail = $final_image_url;
                }

                if ($request->hasFile('photo')) {
                    if (file_exists($prev_picture2)) {
                        @unlink($prev_picture2);
                    }
                    $file = $request->file('photo');
                    $path = 'open_graph_image';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $resource->open_graph_image = $final_image_url;
                }


                if ($request->hasFile('featured_image')) {
                    if (file_exists($prev_feature_image)) {
                        @unlink($prev_feature_image);
                    }
                    $file = $request->file('featured_image');
                    $path = 'seo_featured_image';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $resource->featured_image = $final_image_url;
                }
                $resource->resource_desc = $request->resource_desc;
                $resource->save();
                session()->flash('success', 'Resource updated');
                return redirect()->route('admin.resource-list');
            } catch (\Throwable $th) {
                Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
                abort(500);
            }
        }
        return Inertia::render('Admin/resource/CreateEdit', ['resources' => $resource]);
    }

    public function deleteResource(Request $request, $id)
    {
        try {
            $resource = Resource::findOrfail($id);
            $resource->delete();
            session()->flash('success', 'Resource successfully deleted');
            return redirect()->back();
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
        }
    }
}
