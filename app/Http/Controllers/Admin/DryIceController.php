<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\DryIceByCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class DryIceController extends Controller
{
    public function dryiceList(Request $request)
    {
        $dryice = DryIceByCity::query();

        if ($request->slug) {
            $dryice = $dryice->where('slug', 'like', '%' . $request->slug . '%');
        }

        if (isset($request->active)) {
            $dryice = $dryice->where('status', $request->active);
        }
        if ($request->created_at) {
            $dryice = $dryice->where('created_at', 'like', '%' . $request->created_at . '%');
        }
        if ($request->fieldName && $request->shortBy) {
            $dryice->orderBy($request->fieldName, $request->shortBy);
        }

        $perPage = $request->perPage ?? 20;

        $dryice = $dryice
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Admin/dry_ice/DryIceList', ['dryice' => $dryice]);
    }

    public function dryiceCreate(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validateData = $request->validate([
                'slug' => ['required', 'max:255'],
                'status' => ['required'],
                'meta_title' => ['nullable', 'max:255'],
                'h1_tag' => ['nullable', 'max:500'],
                'meta_description' => ['nullable', 'max:500'],
                'city_lowercase' => ['nullable', 'max:255'],
                'state_short_abbr' => ['nullable', 'max:255'],
                'city' => ['nullable'],
                'state_code' => ['nullable'],
                'state' => ['nullable'],
                'zip_codes' => ['nullable','numeric'],
                'type' => ['nullable', 'max:255'],
                'latitude' => ['nullable', 'max:255'],
                'longitude' => ['nullable', 'max:255'],
                'faq_q_1' => ['nullable', 'max:500'],
                'faq_a_1' => ['nullable', 'max:500'],
                'faq_q_2' => ['nullable', 'max:500'],
                'faq_a_2' => ['nullable', 'max:500'],
                'faq_q_3' => ['nullable', 'max:500'],
                'faq_a_3' => ['nullable', 'max:500'],
                'faq_q_4' => ['nullable', 'max:500'],
                'faq_a_4' => ['nullable', 'max:500'],
                'faq_q_5' => ['nullable', 'max:500'],
                'faq_a_5' => ['nullable', 'max:500'],
                'faq_q_6' => ['nullable', 'max:500'],
                'faq_a_6' => ['nullable', 'max:500'],
                'faq_q_7' => ['nullable', 'max:500'],
                'faq_a_7' => ['nullable', 'max:500'],
            ]);
            try {
                $dryice = new DryIceByCity();
                $dryice->fill($validateData)->save();
                session()->flash('success', 'Dry Ice by city successfully added');
                return redirect()->route('admin.dry.ice.list');
            } catch (\Throwable $th) {
                Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
                abort(500);
            }
        }
        return Inertia::render('Admin/dry_ice/CreateEdit');
    }

    public function editDryIce(Request $request, $id)
    {
        $dryice = DryIceByCity::findOrfail($id);
      

        if ($request->isMethod('post')) {
            // dd($request->all());
            $validateData = $request->validate([
                'slug' => ['required', 'max:255'],
                'status' => ['required'],
                'meta_title' => ['nullable', 'max:255'],
                'h1_tag' => ['nullable', 'max:500'],
                'meta_description' => ['nullable', 'max:500'],
                'city_lowercase' => ['nullable', 'max:255'],
                'state_short_abbr' => ['nullable', 'max:255'],
                'city' => ['nullable'],
                'state_code' => ['nullable'],
                'state' => ['nullable'],
                'zip_codes' => ['nullable','numeric'],
                'type' => ['nullable'],
                'latitude' => ['nullable'],
                'longitude' => ['nullable'],
                'faq_q_1' => ['nullable', 'max:500'],
                'faq_a_1' => ['nullable', 'max:500'],
                'faq_q_2' => ['nullable', 'max:500'],
                'faq_a_2' => ['nullable', 'max:500'],
                'faq_q_3' => ['nullable', 'max:500'],
                'faq_a_3' => ['nullable', 'max:500'],
                'faq_q_4' => ['nullable', 'max:500'],
                'faq_a_4' => ['nullable', 'max:500'],
                'faq_q_5' => ['nullable', 'max:500'],
                'faq_a_5' => ['nullable', 'max:500'],
                'faq_q_6' => ['nullable', 'max:500'],
                'faq_a_6' => ['nullable', 'max:500'],
                'faq_q_7' => ['nullable', 'max:500'],
                'faq_a_7' => ['nullable', 'max:500'],
            ]);
            try {
                $dryice->fill($validateData)->save();
                session()->flash('success', 'Dry ice by city updated');
                return redirect()->route('admin.dry.ice.list');
            } catch (\Throwable $th) {
                Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
                abort(500);
            }
        }
        return Inertia::render('Admin/dry_ice/CreateEdit', ['dryice' => $dryice]);
    }

    public function deleteDryIce($id){
        DryIceByCity::where('id', $id)->delete();
        session()->flash('success', 'Dry ice by city successfully deleted');
        return back();
    }

}
