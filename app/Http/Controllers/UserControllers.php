<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\routes\web;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserControllers extends Controller
{
    public function index()
    {
        return view('registration.user');
    }

    public function showLogin()
    {
        return view('registration.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'confirmed',
                // Password::min(8)
                //     ->letters()
                //     ->mixedCase()
                //     ->numbers()
                //     ->symbols()
                //     ->uncompromised()
            ],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
        ]);
        $user->student()->create();

        return redirect('user/create')->with('status', 'success');
    }

    public function create()
    {
        return view('registration.create');
    }

    public function loginPage(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if ( ! Auth::attempt($credentials)) {
            return redirect()->back()
                ->with('error', 'Invalid email or password.');
        }

        $user = Auth::user();
        if ($user && $user->is_active) {
            $routeName = 'home';
            if ($user->is_admin) {
                $routeName = 'admin';
            }

            return redirect()->route($routeName);
        }

        Auth::logout();

        return redirect()->route('login')->with('error',
            'Your account is not active. Please contact the administrator.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('user');
    }
}
