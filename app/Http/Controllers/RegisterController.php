<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;

use App\Models\Admin;
use App\Models\Bursary;
use App\Models\Participant;
use App\Models\PP_admin;
use App\Models\Student;
use App\Models\Tech_team;
use App\Models\User;
use App\Models\Vendor;

class RegisterController extends Controller
{
    public function create()
    {
        // reditect user to register page
        return view('ManageUser.register');
    }

    // get the user id of newly created account
    private function get_user_id(User $user): int {
        return $user->user_ID;
    }

    //  create participant and return participant ID when participant create account in the system
    private function create_participant(User $user): int {
        $participant_information = array("user_ID" => self::get_user_id($user));
        $new_participant = Participant::create($participant_information);

        return $new_participant->parti_ID;
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

        switch($attributes["role"]) {
            case "student":
                $new_student = array("std_ID" => "cb12345", "parti_ID" => self::create_participant($user));
                Student::create($new_student);
                break;
            
            case "vendor":
                $new_vendor = array("parti_ID" => self::create_participant($user), "IC_number" => "012569874563");
                Vendor::create($new_vendor);
                break;
            
            case "admin":
                $new_admin = array("user_ID" => self::get_user_id($user));
                Admin::create($new_admin);
                break;

            case "bursary":
                $new_bursary = array("user_ID" => self::get_user_id($user));
                Bursary::create($new_bursary);
                break;
            
            case "tech_team":
                $new_teach_team = array("user_ID" => self::get_user_id($user));
                Tech_team::create($new_teach_team);
                break;

            case "pp_admin":
                $new_pp_admin = array("user_ID" => self::get_user_id($user));
                PP_admin::create($new_pp_admin);
                break;

            default:
                break;
        }
        auth()->login($user);

        return redirect('/dashboard');
    }

    

}
