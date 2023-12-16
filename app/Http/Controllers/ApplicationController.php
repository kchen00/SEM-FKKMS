<?php

namespace App\Http\Controllers;

use App\Models\application;
use App\Http\Requests\StoreapplicationRequest;
use App\Http\Requests\UpdateapplicationRequest;
use App\Models\participant;
use Faker\Provider\ar_EG\Company;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $participant = participant::where('user_ID',auth()->user()->user_ID)->first();
        $applications = application::where('parti_ID', $participant['parti_ID'])
        ->orderBy('created_at', 'desc')
        ->get();
        // dd($applications, $participant);
        return view('manageApplication.manage',compact('applications'));
    }

    public function adminManage()
    {
        $applications = Application::orderBy('created_at', 'desc')->get();
        return view('manageApplication.adminManage', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $participant = participant::where('user_ID',auth()->user()->user_ID)->first();
        $applications = Application::where('parti_ID', $participant->parti_ID)
        ->whereIn('status', ['received', 'on reviewed'])
        ->get();
        if($applications->count()> 0)
        {
            return redirect()->route('application.manage')->with('error', 'Already have on going application');
        }
        else{
            return view('manageApplication.create');
        }
        // dd($applications, $participant);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = auth()->user();
        $participant = participant::where('user_ID', $user['user_ID'])->first();
        $request->merge([
            'parti_ID' => $participant['parti_ID'],
            'status'=> 'received',
        ]);
        // dd($request, $participant, $user);
        application::create($request->all());
        return redirect(route('application.manage'));
    }

    /**
     * Display the specified resource.
     */
    public function show(application $application)
    {
        //
        return view('manageApplication.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        //
        $application = application::where('application_ID',$id)->first();
        return view('manageApplication.edit',compact('application'));
    }
    
    public function adminEdit(Request $request, $id)
    {
        //
        $application = application::where('application_ID',$id)->first();
        $status = [
            'status' => 'on review'
        ];
        $application->update($status);
        return view('manageApplication.adminEdit',compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $application = application::where('application_ID', $id)->first();
        $application->update($request->all());
        return redirect(route('application.manage'));
    }
   
    public function adminUpdate(Request $request, $id)
    {
        $application = application::where('application_ID', $id)->first();
        $application->update($request->all());
        return redirect(route('application.adminManage'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(application $application)
    {
        //
    }
}
