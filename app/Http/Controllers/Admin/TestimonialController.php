<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Helpers\PermissionHelper;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $testimonials = Testimonial::query();

        if ($request->username) {
            $testimonials = $testimonials->where('username', 'like', '%' . trim($request->username) . '%');
        }
        if ($request->description) {
            $testimonials = $testimonials->where('description', 'like', '%' . trim($request->description) . '%');
        }

        if ($request->rating) {
            $testimonials = $testimonials->where('rating', 'like', '%' . trim($request->rating) . '%');
        }

        $perPage = 20;
        if ($request->perPage) {
            $perPage = $request->perPage;
        }
        $testimonials = $testimonials->orderBy('id', 'desc')->paginate($perPage)->withQueryString();

        return Inertia::render('Admin/testimonial/List', compact('testimonials'));
    }

    public function createTestimonial()
    {
        return Inertia::render('Admin/testimonial/CreateEdit');
    }

    public function createTestimonialPost(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|max:255',
            'description' => 'required|max:500',
            'rating' => 'required|numeric|min:1|max:5',
        ], ['description.required' => 'The review field is required.']);

        Testimonial::create($validatedData);
        session()->flash('success', 'Testimonial updated successfully');
        return redirect()->route('admin.testimonial');
    }

    public function editTestimonial($id)
    {
        $testimonial = Testimonial::whereId($id)->first();
        return Inertia::render('Admin/testimonial/CreateEdit', compact('testimonial'));
    }

    public function updateTestimonial(Request $request, $id)
    {
        $validatedData = $request->validate([
            'username' => 'required|max:255',
            'description' => 'required|max:500',
            'rating' => 'required|numeric|min:1|max:5',
        ], ['description.required' => 'The review field is required.']);

        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update($validatedData);
        session()->flash('success', 'Testimonial updated successfully');
        return redirect()->route('admin.testimonial');
    }

    public function deleteTestimonial($id)
    {
        try {
            Testimonial::where('id', $id)->delete();
            session()->flash('success', 'Testimonial deleted successfully');
            return back();
        } catch (\Throwable $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }
}
