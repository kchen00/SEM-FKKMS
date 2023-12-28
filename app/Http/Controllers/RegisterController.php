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

    public function admin_create() {
        return view("ManageUser.admin-add-user");
    }

    // get the user id of newly created account
    private function get_user_id(User $user): int {
        return $user->user_ID;
    }

    // login after account is creadted
    public function create_session(User $user) {
        auth()->login($user);
    }

    //  create participant and return participant ID when participant create account in the system
    private function create_participant(User $user): int {
        $participant_information = array("user_ID" => self::get_user_id($user));
        $new_participant = Participant::create($participant_information);

        return $new_participant->parti_ID;
    }

    // perform validation of new account and store it in the databse
    public function store()
    {
        $attributes = [
            'email' => 'required|email|max:255|unique:users,email',
            'username' => 'required|max:255|min:2',
            'phone_num' => 'required|max:12|unique:users,phone_num',
            'password' => 'required|min:5|max:255|confirmed',
            'role' => 'required',
            'terms' => 'required'
        ];

        // Array to hold dynamic validation rules
        $dynamicRules = [];

        $selectedRole = request('role');
        // Apply dynamic validation rules based on the selected role
        if ($selectedRole === 'student') {
            $dynamicRules['matric_number'] = 'required|max:7|unique:students,std_ID'; 
        }
        if ($selectedRole === 'vendor') {
            $dynamicRules['ic_number'] = 'required|max:12|unique:vendors,IC_number';
        }

        // Merge dynamic rules with existing validation rules
        $attributes = array_merge($attributes, $dynamicRules);

        // Perform the validation with the dynamically added rules
        $validatedAttributes = request()->validate($attributes);

        $user = User::create($validatedAttributes);

        switch($validatedAttributes["role"]) {
            case "student":
                $new_student = array("std_ID" => $validatedAttributes["matric_number"], "parti_ID" => self::create_participant($user));
                Student::create($new_student);
                break;
            
            case "vendor":
                $new_vendor = array("parti_ID" => self::create_participant($user), "IC_number" =>  $validatedAttributes["ic_number"]);
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

        return $user;
    }

    // store the accounts created publicly
    public function public_store() {
        $this->create_session($this->store());
        return redirect('/dashboard');
    }

    // store the accounts created by the admins
    public function admin_store() {
        $this->store();
        return redirect()->back()->with('success', 'User added successfully');
    }
        
}
