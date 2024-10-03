<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\ChooseForDryIce;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChooseForController extends Controller
{
    public function ChooseForList(Request $request)
    {
        $chooseFor = ChooseForDryIce::query();

        if ($request->title) {
            $chooseFor = $chooseFor->where('title', 'LIKE', '%' . $request->title . '%');
        }
        if (isset($request->status)) {
            $chooseFor = $chooseFor->where('status', $request->status);
        }

        if ($request->fieldName && $request->shortBy) {
            $chooseFor->orderBy($request->fieldName, $request->shortBy);
        }

        $perPage = $request->perPage ?? 20;

        $chooseFor = $chooseFor
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Admin/choose_for/List', ['chooseFor' => $chooseFor]);
    }

    public function createChooseFor(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'title' => 'required|max:50',
                'photo' => 'required|mimes:jpeg,png,jpg',
                'status' => 'required',
            ]);

            $choose_for = new ChooseForDryIce();
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $path = 'choose-for-photo';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $credentials['thumbnail'] = $final_image_url;
            }
            $choose_for->fill($credentials)->save();

            session()->flash('success', 'Choose for successfully created');
            return redirect()->route('admin.choose-for');
        }

        return Inertia::render('Admin/choose_for/CreateEdit');
    }

    public function editChooseFor(Request $request, $id)
    {
        $choose_for = ChooseForDryIce::find($id);
        $prev_picture = $choose_for->thumbnail;
        if (request()->isMethod('post')) {
            $credentials = $request->validate([
                'title' => 'required|max:50',
                'status' => 'required',
                'photo' => $request->hasFile('photo') ? 'mimes:jpeg,png,jpg' : '',
            ]);

            if ($request->hasFile('photo')) {
                if (file_exists($prev_picture)) {
                    @unlink($prev_picture);
                }

                $file = $request->file('photo');
                $path = 'choose-for-photo';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $credentials['thumbnail'] = $final_image_url;
            }
            $choose_for->fill($credentials)->save();

            session()->flash('success', 'Choose For successfully updated');
            return redirect()->route('admin.choose-for');
        }
        return Inertia::render('Admin/choose_for/CreateEdit', compact('choose_for'));
    }

    public function deleteChooseFor($id)
    {
        $chooseFor = ChooseForDryIce::findOrFail($id);

        /** If thumbnail exists, delete it */
        if (!empty($chooseFor->thumbnail) && file_exists(public_path($chooseFor->thumbnail))) {
            @unlink(public_path($chooseFor->thumbnail));
        }
        $chooseFor->delete();

        session()->flash('success', 'Choose for Dry Ice successfully deleted');
        return back();
    }

    public function changeChooseForStatus(Request $request)
    {
        $chooseForDryIce = ChooseForDryIce::find($request->id);
        $chooseForDryIce->fill(['status' => !$chooseForDryIce->status])->save();
        session()->flash('success', 'choose for status successfully changed');
        return back();
    }
}
