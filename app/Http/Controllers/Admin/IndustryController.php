<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndustryController extends Controller
{
    public function index(Request $request)
    {
        $industries = Industry::query();

        if ($request->title) {
            $industries = $industries->where('title', 'LIKE', '%' . $request->title . '%');
        }
        if (isset($request->status)) {
            $industries = $industries->where('status', $request->status);
        }
        if (isset($request->slug)) {
            $industries = $industries->where('slug','LIKE','%'. $request->slug.'%');
        }
        $perPage = $request->perPage ?? 20;

        $industries = $industries
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Admin/Industry/List', compact('industries'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules =  [
                'title' => 'required|max:255|unique:industries,title',
                'short_description' => 'required|max:1000',
                'description' => 'required',
                'status' => 'required',
                'thumbnail' =>  'required|mimes:jpeg,png,jpg|max:2048',
                'slug' => 'required',
                'h1' => 'nullable|max:225',
                'meta_title' => ['nullable', 'max:500'],
                'meta_description' => 'nullable|max:500',
                'open_graph_title' => ['nullable', 'max:500'],
                'open_graph_url' => ['nullable', 'url'],
                'open_graph_description' => 'nullable|max:500',
                'open_graph_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'featured_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
                'x_card_description' => 'nullable|max:500',
                'x_card_title' => ['nullable', 'max:500'],

            ];
            $customMessages = [
                'required' => 'The field is required',
                'thumbnail.required' => "The thumbnail is required",
                'thumbnail.max' => "The thumbnail size should be less than 2MB",
                'open_graph_image.max' => "The thumbnail size should be less than 2MB",
                'thumbnail.mimes' => "The thumbnail field must be a file of type: jpeg, png, jpg."
            ];

            $request->validate($rules, $customMessages);
            $industry = new Industry();
            $industry->title = $request->title;
            $industry->short_description = $request->short_description;
            $industry->description = $request->description;
            $industry->status = $request->status;

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $path = 'industry_image';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $industry->thumbnail = $final_image_url;
            }
            $industry->slug = $request->slug;
            $industry->h1 = $request->h1;
            $industry->meta_title = $request->meta_title;
            $industry->meta_description = $request->meta_description;
            $industry->open_graph_title = $request->open_graph_title;
            $industry->open_graph_description = $request->open_graph_description;
            $industry->open_graph_url = $request->open_graph_url;
            $industry->x_card_title = $request->x_card_title;
            $industry->x_card_description = $request->x_card_description;

            if ($request->hasFile('open_graph_image')) {
                $file = $request->file('open_graph_image');
                $path = 'open_graph_image';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $industry->open_graph_image = $final_image_url;
            }
            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                $path = 'seo_featured_image';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $industry->featured_image = $final_image_url;
            }
            $industry->save();
            session()->flash('success', 'Industry created successfully');
            return redirect()->route('admin.industry');
        }
        return Inertia::render('Admin/Industry/CreateEdit');
    }

    public function edit($id)
    {
        $industry = Industry::where('id', $id)->first();
        return Inertia::render('Admin/Industry/CreateEdit', compact('industry'));
    }

    public function update(Request $request, $id)
    {
        $rules =  [
            'title' => 'required|max:255|unique:industries,title,' . $id,
            'short_description' => 'required|max:1000',
            'description' => 'required',
            'status' => 'required',
            'thumbnail' =>  'nullable|mimes:jpeg,png,jpg|max:2048',
            'slug' => 'required',
            'h1' => 'nullable|max:225',
            'meta_title' => ['nullable', 'max:500'],
            'meta_description' => 'nullable|max:500',
            'open_graph_url' => ['nullable', 'url'],
            'open_graph_title' => ['nullable', 'max:500'],
            'open_graph_description' => 'nullable|max:500',
            'open_graph_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'featured_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'x_card_description' => 'nullable|max:500',
            'x_card_title' => 'nullable|max:500',
        ];

        $customMessages = [
            'required' => 'The field is required',
            'thumbnail.max' => "The thumbnail size should be less than 2MB",
            'open_graph_image.max' => "The thumbnail size should be less than 2MB",
        ];
        $request->validate($rules, $customMessages);

        $industry = Industry::whereId($id)->first();

        if ($industry) {
            $industry->title = $request->title;
            $industry->status = $request->status;
            $industry->short_description = $request->short_description;
            $industry->description = $request->description;
            $prev_picture = $industry->thumbnail;
            $prev_picture_open_graph = $industry->open_graph_image;
            $prev_feature_image = $industry->featured_image;

            if ($request->hasFile('thumbnail')) {
                if (file_exists($prev_picture)) {
                    @unlink($prev_picture);
                }
                $file = $request->file('thumbnail');
                $path = 'industry_image';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $industry->thumbnail = $final_image_url;
            }
            $industry->slug = $request->slug;
            $industry->h1 = $request->h1;
            $industry->meta_title = $request->meta_title;
            $industry->meta_description = $request->meta_description;
            $industry->open_graph_title = $request->open_graph_title;
            $industry->open_graph_description = $request->open_graph_description;
            $industry->open_graph_url = $request->open_graph_url;
            $industry->x_card_title = $request->x_card_title;
            $industry->x_card_description = $request->x_card_description;
            // $industry->canonical_url = $request->canonical_url;

            if ($request->hasFile('open_graph_image')) {
                if (file_exists($prev_picture_open_graph)) {
                    @unlink($prev_picture_open_graph);
                }

                $file = $request->file('open_graph_image');
                $path = 'open_graph_image';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $industry->open_graph_image = $final_image_url;
            }
            if ($request->hasFile('featured_image')) {
                if (file_exists($prev_feature_image)) {
                    @unlink($prev_feature_image);
                }
                $file = $request->file('featured_image');
                $path = 'seo_featured_image';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $industry->featured_image = $final_image_url;
            }
            $industry->save();
        }
        session()->flash('success', 'Industry details updated successfully');
        return redirect()->route('admin.industry');
    }
    public function changeStatus(Request $request)
    {
        $industry = Industry::findOrFail($request->id);
        $industry->fill(['status' => !$industry->status])->save();
        session()->flash('success', 'Status successfully changed');
        return back();
    }

    public function deleteIndustry($id)
    {
        $industry = Industry::findOrFail($id);

        /** If thumbnail exists, delete it */
        if (!empty($industry->thumbnail) && file_exists(public_path($industry->thumbnail))) {
            @unlink(public_path($industry->thumbnail));
        }
        $industry->delete();

        session()->flash('success', 'Industry details deleted successfully.');
        return back();
    }
}
