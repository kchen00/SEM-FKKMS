<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        // reditect user to register page
        return view('ManageUser.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'username' => 'required|max:255|min:2',
            'phone_num' => 'required|max:12|unique:users,phone_num',
            'password' => 'required|min:5|max:255|confirmed',
            'role' => 'required',
            'terms' => 'required'
        ]);
        $user = User::create($attributes);
        auth()->login($user);

        return redirect('/dashboard');
    }
}
