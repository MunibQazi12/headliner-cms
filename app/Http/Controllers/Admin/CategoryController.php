<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Helpers\ImageHelper;

class CategoryController extends Controller
{
    public function getCategoryPage(Request $request)
    {
        $categories = Category::query();

        if ($request->title) {
            $categories = $categories->where('title', 'like', '%' . $request->title . '%');
        }
        if (isset($request->active)) {
            $categories = $categories->where('active', $request->active);
        }
        if ($request->fieldName && $request->shortBy) {
            $categories->orderBy($request->fieldName, $request->shortBy);
        }
        $perPage = $request->perPage ?? 20;
        $categories = $categories
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        return Inertia::render('Admin/category/CategoryPage', ['categories' => $categories]);
    }

    public function createCategory(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate(
                [
                    'title' => 'required|max:50',
                    'desc' => 'required',
                    'active' => 'required',
                    'thumbnail' => 'required|mimes:jpeg,png,jpg'
                ],
                [
                    'active' => 'The status field is required'
                ]
            );

            $user = new Category();
            $user->title = $request->title;
            $user->desc = $request->desc;
            $user->active = $request->active;
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $path = 'category_thumbnails';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $user->thumbnail = $final_image_url;
            }
            $user->save();
            session()->flash('success', 'Category successfully created');
            return redirect()->route('admin.category');
        }

        return Inertia::render('Admin/category/CreateEdit');
    }

    public function changeCategoryStatus(Request $request)
    {
        $category = Category::find($request->id);
        $category->active = !$category->active;
        $category->save();
        session()->flash('success', 'Category status successfully changed');
        return back();
    }

    public function categoryDelete($id)
    {
        $category = Category::find($id);
        if (isset($category->thumbnail) && file_exists($category->thumbnail)) {
            @unlink($category->thumbnail);
        }
        Category::where('id', $id)->delete();

        session()->flash('success', 'Category successfully deleted');
        return back();
    }

    public function editCategory(Request $request, $id)
    {
        $category = Category::find($id);
        $prev_picture = $category->thumbnail;
        if (request()->isMethod('post')) {
            $credentials = $request->validate([
                'title' => 'required|max:50',
                'desc' => 'required',
                'active' => 'required',
                'thumbnail' => $request->hasFile('thumbnail') ? 'mimes:jpeg,png,jpg' : '',
            ], [
                'active' => 'The status field is required'
            ]);

            $category->title = $request->title;
            $category->desc = $request->desc;
            $category->active = $request->active;
            if ($request->hasFile('thumbnail')) {
                if (file_exists($prev_picture)) {
                    @unlink($prev_picture);
                }

                $file = $request->file('thumbnail');
                $path = 'category_thumbnails';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $category->thumbnail = $final_image_url;
            }
            $category->save();

            session()->flash('success', 'Category successfully updated');
            return redirect()->route('admin.category');
        }
        return Inertia::render('Admin/category/CreateEdit', compact('category'));
    }
}
