<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function delete(User $user)
    {
        $user->delete();

        return redirect()->back();
    }

    public function edit(User $user, Request $request)
    {
        $request->validate([
            'name'      => [
                'string',
                'required',
            ],
            'email'     => [
                'email',
                'required',
            ],
            'is_active' => [
                'boolean',
            ],
        ]);

        $user->update([
            'email'     => $request->get('email'),
            'is_active' => $request->get('is_active'),
            'name'      => $request->get('name'),
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => [
                'required',
                'email',
            ],
            'password'  => [
                'required',
                'confirmed',
                // Password::min(8)
                //     ->letters()
                //     ->mixedCase()
                //     ->numbers()
                //     ->symbols()
                //     ->uncompromised()
            ],
            'is_active' => [
                'boolean',
            ],
        ]);

        $user = User::create($request->all());

        $user->student()->create();

        return redirect()->back()->with('status', 'success');
    }
}
