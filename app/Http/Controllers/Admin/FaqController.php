<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $faq = Faq::query();

        if ($request->question) {
            $faq = $faq->where('question', 'like', '%' . $request->question . '%');
        }

        if ($request->answer) {
            $faq = $faq->where('answer', 'like', '%' . $request->answer . '%');
        }

        if (isset($request->active)) {
            $faq = $faq->where('active', $request->active);
        }

        if ($request->fieldName && $request->shortBy) {
            $faq->orderBy($request->fieldName, $request->shortBy);
        }

        $perPage = $request->perPage ?? 20;

        $faqs = $faq->orderBy('id', 'desc')->paginate($perPage)->withQueryString();
        return Inertia::render('Admin/faq/List', ['faqs' => $faqs]);
    }

    public function create()
    {
        try {
            return Inertia::render('Admin/faq/CreateEdit');
        } catch (\Throwable $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'question' => 'required|max:255',
                'answer' => 'required|',
                'active' => 'required',
            ],
            [
                'active.required'    => 'The status field is required',
            ]
        );

        $faq = new Faq;
        $faq->fill($request->all());
        $faq->save();
        session()->flash('success', 'FAQ created successfully');
        return redirect()->route('admin.faq.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $faq = Faq::find($id);
            return Inertia::render('Admin/faq/CreateEdit', compact('faq'));
        } catch (\Throwable $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'question' => 'required|max:255',
                'answer' => 'required',
                'active' => 'required',
            ],
            [
                'active.required'    => 'The status field is required',
            ]
        );

        try {
            $faq = Faq::find($id);
            $faq->fill($request->all());
            $faq->save();
            session()->flash('success', 'Faq updated successfully');
            return redirect()->route('admin.faq.index');
        } catch (\Throwable $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Faq::where('id', $id)->delete();
            session()->flash('success', 'FAQ deleted successfully');
            return back();
        } catch (\Throwable $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }


    public function changeFaqStatus(Request $request)
    {
        try {
            $faq = Faq::find($request->id);
            $faq->active = !$faq->active;
            $faq->save();
            session()->flash('success', 'FAQ status successfully changed');
            return back();
        } catch (\Throwable $e) {
            Log::error(" :: EXCEPTION :: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            abort(500);
        }
    }
}
