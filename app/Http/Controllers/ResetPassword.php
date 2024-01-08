<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Notifications\ForgotPassword;
use Illuminate\Support\Facades\Auth;

class ResetPassword extends Controller
{
    use Notifiable;

    public function show()
    {
        return view('ManageUser.reset-password');
    }
    
    // show the password reset form to first time login admin
    public function admin_show() {
        $affected_roles = ["admin", "pp_admin", "bursary", "tech_team"];
        if (Auth::check() && Auth::user()->created_at == Auth::user()->updated_at && in_array(Auth::user()->role, $affected_roles)){
            return view("ManageUser.admin-reset");
        }

        return redirect()->route('home')->with('error', 'You are not allowed to access this page.');
    }
    
    public function routeNotificationForMail() {
        return request()->email;
    }

    public function send(Request $request)
    {
        $email = $request->validate([
            'email' => ['required']
        ]);
        $user = User::where('email', $email)->first();

        if ($user) {
            $this->notify(new ForgotPassword($user->id));
            return back()->with('succes', 'An email was send to your email address');
        }
    }

}

