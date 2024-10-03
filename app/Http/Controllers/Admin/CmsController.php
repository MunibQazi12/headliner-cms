<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Cms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CmsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $pages = Cms::query();

            if ($request->title) {
                $pages = $pages->where('title', 'like', '%' . $request->title . '%');
            }
            if ($request->slug) {
                $pages = $pages->where('slug', 'like', '%' . $request->slug . '%');
            }

            if ($request->fieldName && $request->shortBy) {
                $pages->orderBy($request->fieldName, $request->shortBy);
            }

            if ($request->fieldName && $request->shortBy) {
                $pages->orderBy($request->fieldName, $request->shortBy);
            }

            $perPage = $request->perPage ?? 20;

            $pages = $pages
                ->orderBy('id', 'desc')
                ->paginate($perPage)
                ->withQueryString();
            return Inertia::render('Admin/cms/List', ['pages' => $pages]);
        } catch (\Exception $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }

    public function edit($slug)
    {
        try {
            $cms = Cms::where('slug', $slug)->first();
            return Inertia::render('Admin/cms/CreateEdit', compact('cms'));
        } catch (\Exception $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }

    public function update(Request $request, $slug)
    {
        // dd($request->all());
        $validatedData = $request->validate(
            [
                'title' => 'required|max:255',
                'slug' => 'required|max:255',
                'content' => 'nullable',
                'heading' => 'nullable',
                'meta_title' => 'nullable|max:500',
                'meta_description' => 'nullable|max:500',
                'open_graph_title' => 'nullable|max:500',
                'open_graph_description' => 'nullable|max:500',
                'open_graph_url' => 'nullable|url',
                'photo' => $request->hasFile('photo') ? 'mimes:jpeg,png,jpg|max:2048' : '',
                'featured_image' => $request->hasFile('featured_image') ? 'mimes:jpeg,png,jpg|max:2048' : '',
                'x_card_title' => 'nullable|max:500',
                'x_card_description' => 'nullable|max:500',
            ],[
                'photo.max'=>'Image should not be greater than 2MB.',
                'featured_image.max'=>'Image should not be greater than 2MB.'
            ]
        );

        try {
            $page = Cms::find($slug);
            // dd($page);
            $page->text_content=$request->content;
            $prev_picture = $page->open_graph_image;
            if ($request->hasFile('photo')) {
                if (file_exists($prev_picture)) {
                    @unlink($prev_picture);
                }

                $file = $request->file('photo');
                $path = 'open_graph_image';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $page->open_graph_image = $final_image_url;
            }
            $prev_featured_image = $page->featured_image;
            if ($request->hasFile('featured_image')) {
                if (file_exists($prev_featured_image)) {
                    @unlink($prev_featured_image);
                }
                $file = $request->file('featured_image');
                $path = 'seo_featured_image';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $page->featured_image = $final_image_url;
            }
            $page->update($validatedData);
            return redirect()->route('admin.cms.index')->with('success', $page->title . ' has been updated');
        } catch (\Throwable $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }
    public function editCmsPages($slug)
    {
        try {
            $cmspage = Cms::where('slug', $slug)->first();
            return Inertia::render('Admin/cms/CmsPageEdit', compact('cmspage'));
        } catch (\Throwable $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }

    public function updateCmsPages(Request $request, $slug)
    {
        // dd($request->all());
        $validatedData = $request->validate(
            [
                'title' => 'required|max:255',
                'slug' => 'required|max:255',
                'heading' => 'nullable',
                'content' => 'required|max:500',
                'short_desc' => 'nullable|max:500',
                'sub_title_one' => 'nullable',
                'sub_title_two' => 'nullable',
                'button_text' => 'nullable',
                'button_url' => 'nullable|url',
                'meta_title' => 'nullable|max:500',
                'meta_description' => 'nullable|max:500',
                'open_graph_title' => 'nullable|max:500',
                'open_graph_description' => 'nullable|max:500',
                'open_graph_url' => 'nullable|url',
                'photo' => $request->hasFile('photo') ? 'mimes:jpeg,png,jpg|max:2048' : '',
                'featured_image' => $request->hasFile('featured_image') ? 'mimes:jpeg,png,jpg|max:2048' : '',
                'x_card_title' => 'nullable|max:500',
                'x_card_description' => 'nullable|max:500',
            ]
        );

        try {
            $page = Cms::find($slug);
            $page->text_content=$request->content;
            $prev_picture = $page->open_graph_image;
            if ($request->hasFile('photo')) {
                if (file_exists($prev_picture)) {
                    @unlink($prev_picture);
                }

                $file = $request->file('photo');
                $path = 'open_graph_image';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $page->open_graph_image = $final_image_url;
            }
            $prev_featured_image = $page->featured_image;
            if ($request->hasFile('featured_image')) {
                if (file_exists($prev_featured_image)) {
                    @unlink($prev_featured_image);
                }

                $file = $request->file('featured_image');
                $path = 'seo_featured_image';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $page->featured_image = $final_image_url;
            }
            $page->update($validatedData);
            // $page->save();
            return redirect()->route('admin.cms.index')->with('success', $page->title . ' has been updated');
        } catch (\Throwable $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validatedData = $request->validate(
                [
                    'title' => 'required|max:255',
                    'slug' => 'required|max:255',
                    'content' => 'required|max:500',
                    'heading' => 'nullable|max:255',
                    'meta_title' => 'nullable|max:500',
                    'meta_description' => 'nullable|max:500',
                    'featured_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
                    'open_graph_title' => 'nullable|max:500',
                    'open_graph_description' => 'nullable|max:500',
                    'open_graph_url' => 'nullable|url',
                    'photo' => 'nullable|mimes:jpeg,png,jpg|max:2048',
                    'x_card_title' => 'nullable|max:500',
                    'x_card_description' => 'nullable|max:500',
                ],
                [
                    'text_content' => 'The short description field is required.',
                    'featured_image.max' => 'Image should not be greater than 2MB. '
                ]
            );
            try {
                // dd($request->content);
                $cms = new Cms;
                $cms->title = $request->title;
                $cms->slug = $request->slug;
                $cms->text_content = $request->content;
                $cms->meta_title = $request->meta_title;
                $cms->meta_description = $request->meta_description;
                $cms->heading = $request->heading;
                $cms->open_graph_title = $request->open_graph_title;
                $cms->open_graph_description = $request->open_graph_description;
                $cms->open_graph_url = $request->open_graph_url;
                $cms->x_card_title = $request->x_card_title;
                $cms->x_card_description = $request->x_card_description;
                if ($request->hasFile('featured_image')) {
                    $file = $request->file('featured_image');
                    $path = 'seo_featured_image';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $cms->featured_image = $final_image_url;
                }
                if ($request->hasFile('open_graph_image')) {
                    $file = $request->file('open_graph_image');
                    $path = 'open_graph_image';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $cms->open_graph_image = $final_image_url;
                }
                $cms->save();
                return redirect()->route('admin.cms.index')->with('success', $cms->title . ' page is created');
            } catch (\Throwable $th) {
                Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
                abort(500);
            }
        }
        return Inertia::render('Admin/cms/CmsNewPages');
    }
}
