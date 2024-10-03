<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistributionCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class DistributorController extends Controller
{
    public function index(Request $request)
    {
        $distributor = DistributionCenter::query();
        if ($request->name) {
            $distributor = $distributor->where('center_name', 'like', '%' . trim(addslashes($request->name) . '%'));
        }
        if ($request->fieldName && $request->shortBy) {
            $distributor->orderBy($request->fieldName, $request->shortBy);
        }

        $perPage = $request->perPage ?? 20;

        $distributions = $distributor->orderBy('id', 'desc')->paginate($perPage)->withQueryString();

        return Inertia::render('Admin/distribution/List', ['distributions' => $distributions]);
    }

    public function createDistribution(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->validate(
                [
                    'center_name' => 'required',
                    'address_line_1' => 'required',
                    'status' => 'required',
                    'latitude' => 'required',
                    'longitude' => 'required',
                ],
                [
                    'address_line_1.required' => 'Address field is required'
                ]
            );

            $distribution = new DistributionCenter();
            $distribution->fill($credentials)->save();
            session()->flash('success', 'Distribution Center successfully created');
            return redirect()->route('admin.distribution.center');
        }
        return Inertia::render('Admin/distribution/CreateEdit');
    }

    public function editDistribution(Request $request, $id)
    {

        $distribution = DistributionCenter::find($id);
        if (request()->isMethod('post')) {
            // dd($request->address_line_1);
            $credentials = $request->validate([
                'center_name' => 'required',
                'address_line_1' => 'required',
                'status' => 'required',
                'latitude' => 'nullable',
                'longitude' => 'nullable'
            ]);

            $distribution->fill($credentials)->save();

            session()->flash('success', 'Distribution Center successfully updated');
            return redirect()->route('admin.distribution.center');
        }
        return Inertia::render('Admin/distribution/CreateEdit', compact('distribution'));
    }

    public function changeStatus(Request $request)
    {
        try {
            $distribution = DistributionCenter::find($request->id);
            $distribution->status = !$distribution->status;
            $distribution->save();
            session()->flash('success', 'Distribution Center status successfully changed');
            return back();
        } catch (\Throwable $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }

    public function deleteDistribution($id)
    {
        $distribution = DistributionCenter::findOrFail($id);
        $distribution->delete();

        session()->flash('success', 'Distribution center successfully deleted');
        return back();
    }
}
