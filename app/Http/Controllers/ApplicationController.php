<?php

namespace App\Http\Controllers;

use App\Models\application;
use App\Http\Requests\StoreapplicationRequest;
use App\Http\Requests\UpdateapplicationRequest;
use App\Models\kiosk;
use App\Models\participant;
use Faker\Provider\ar_EG\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;



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
        $kiosks = kiosk::where('rented',false)->get();
        if($applications->count()> 0)
        {
            return redirect()->route('application.manage')->with('error', 'Already have on going application');
        }
        elseif($kiosks->count() < 1){
            return redirect()->route('application.manage')->with('error', 'no available kiosk');
        }
        else{
            return view('manageApplication.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        $file = $request->file('file');
        if($file){
            $fileName = $request->input('enddate') . $request->input('startdate') . '.pdf';
    
            Storage::disk('local')->makeDirectory('documents');
    
            Storage::disk('local')->put('documents/' . $fileName, file_get_contents($file->getRealPath()));
        }
        else{
            $fileName = null;
        }

    
        $user = auth()->user();
        $participant = participant::where('user_ID', $user['user_ID'])->first();
        $request->merge([
            'parti_ID' => $participant['parti_ID'],
            'status'=> 'received',
            'SSM' => $fileName
        ]);
        application::create($request->all());
        return redirect(route('application.manage'));
    }

    public function displayFile($fileName)
    {
        $filePath = 'documents/' . $fileName;

        // Check if the file exists
        if (Storage::disk('local')->exists($filePath)) {
            $file = Storage::disk('local')->get($filePath);
            $mimeType = Storage::disk('local')->mimeType($filePath);

            // Return the file response with appropriate headers
            return Response::make($file, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $fileName . '"',
            ]);
        } else {
            // File not found
            abort(404);
        }
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
        $kiosks = kiosk::where('rented',false)->get();
        $application->update($status);
        return view('manageApplication.adminEdit',compact('application','kiosks'));
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
