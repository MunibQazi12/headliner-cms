<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Industry;

class IndustryController extends Controller
{
    public function getIndustries(Request $request)
    {
        $industries = Industry::query();
        
        if ($request->title) {
            $industries = $industries->where('title', 'like', '%' . trim(addslashes($request->title) . '%'));
        }

        if (isset($request->status)) {
            $industries = $industries->where('status', $request->status);
        }

        if ($request->fieldName && $request->shortBy) {
            $industries->orderBy($request->fieldName, $request->shortBy);
        }

        $perPage = $request->perPage ?? 20;

        $industries = $industries
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return response()->json([
            'data' => $industries,
            'message' => 'Data fetched successfully',
        ], 200);
    }

    public function getIndustry($slug)
    {
        $industry = Industry::where('slug', $slug)->first();

        if (!$industry) {
            return response()->json(['error' => 'Industry not found'], 404);
        }

        return response()->json([
            'industry' => $industry,
            'message' => 'Data fetched successfully',
        ], 200);
    }
}
