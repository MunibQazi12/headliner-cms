<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\FooterSettings;
use App\Rules\MatchOldPassword;
use App\Rules\NewOldPasswordNotSame;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user() && (Auth::user()->role_name == 'SUPER-ADMIN')) {
            return to_route('admin.dashboard');
        }
        return Inertia::render('common/SuperAdminLogin');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials) && (Auth::user()->role_name == 'SUPER-ADMIN' || Auth::user()->role_name == 'EDITOR') ) {
            $request->session()->regenerate();
            return Auth::user()->role_name == 'SUPER-ADMIN' ? redirect(session()->pull('url.intended', '/admin/dashboard')) : redirect(session()->pull('url.intended', '/admin/resource-list'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function dashboard(Request $request)
    {
        $data['user'] = User::role('USER')->count();
        $data['getUser'] = User::role('USER')->latest()->limit(5)->get();
        $data['active_user'] = User::role('USER')->whereActive(true)->count();
        $data['inactive_user'] = User::role('USER')->whereActive(false)->count();
        return Inertia::render('Admin/Dashboard', compact('data'));
    }

    function adminProfile(Request $request)
    {
        $user = User::find(Auth::id());
        if (request()->isMethod('post')) {
            $credentials = $request->validate([
                'first_name' => 'required|alpha_num|max:255',
                'last_name' => 'required|alpha_num|max:255',
                'email' =>  'required|max:255|email|unique:users,email,' . $user->id,
                'profile_photo' =>  $request->hasFile('profile_photo') ? 'mimes:jpeg,png,jpg,gif' : '',
            ]);

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $path = 'profile_photo';
                $final_image_url = ImageHelper::customSaveImage($file, $path);
                $user->profile_photo_path = $final_image_url;
            }
            $user->save();

            session()->flash('success', 'Profile updated successfully');
            return redirect('admin/dashboard');
        }

        return Inertia::render('Admin/AdminProfile', compact('user'));
    }

    public function footerSettings(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all(); // Get all input data
    
            foreach ($data as $key => $value) {
                // Check if the entry already exists with the same key
                if($value){
                    $footerSetting = FooterSettings::where('key', $key)->first();
    
                if ($footerSetting) {
                    // Update the existing entry with the new value
                    $footerSetting->value = $value;
                    $footerSetting->save();
                } else {
                    // Create a new entry if the key does not exist
                    FooterSettings::create([
                        'key' => $key,
                        'value' => $value
                    ]);
                }
                }
            }
        }
        $footerSettings = FooterSettings::get();
        return Inertia::render('Admin/FooterSettings', ['footerSettings' => $footerSettings]);
    }


    public function adminChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'min:8', new NewOldPasswordNotSame($request->current_password)],
            'confirm_password' => ['required_with:new_password', 'same:new_password'],
        ]);

        $request->user()->password = $request->new_password;
        $request->user()->save();
        session()->flash('success', 'Password changed successfully');
        return redirect('/admin/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}
