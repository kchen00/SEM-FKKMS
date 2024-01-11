<?php

namespace App\Http\Controllers;

use App\Models\complaint;
use App\Http\Requests\StorecomplaintRequest;
use App\Http\Requests\UpdatecomplaintRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role == "student"||Auth::user()->role == "vendor") {
            return view('ManageComplaint.complaintmenu');
        }
        elseif(Auth::user()->role == "tech_team") {
            return redirect()->route('complaint.show');
        }

        return back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user(); 
        return view('ManageComplaint.complaintform', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $complaint = new Complaint();
        $complaint->parti_ID = $request->parti_ID;
        $complaint->tech_ID = 0;
        $complaint->complaint_title = $request->input('complaintTitle');
        $complaint->description = $request->input('complaintDetails');
        $complaint->complaint_solution = "";
        $complaint->save();

        return redirect()->back()->with('success', 'Complaint stored successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth()->user();
        $complaints = Complaint::where('parti_ID', $user->user_ID)->get();
        return view('ManageComplaint.viewcomplaint', compact('complaints'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(complaint $complaint)
    {
        $complaint->complaint_status = $complaint->input('complaintStatus');
        $complaint->complaint_solution = $complaint->input('solution');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update() //status
    {
        if(Auth::user()->role == "tech_team") {
            $complaints = Complaint::with('user')->get(); 
            $users = User::all();
            $userNamesByUserId = [];

            foreach ($users as $user) {
                $userNamesByUserId[$user->user_ID] = $user->username;
            }
            return view('ManageComplaint.viewcomplaintTech', compact('complaints','userNamesByUserId'));
        }

        return back();
    }

    public function updatestat(Request $request,$complaint_ID) // status
    {
        
        $updatecomplaint = Complaint::where('complaint_ID', $complaint_ID)->first();
        $updatecomplaint->complaint_status = $request->complaint_status;
        $updatecomplaint->save();
        return redirect(route('complaint.show'));
    
    }

    public function storeSolution(Request $request, $complaint_ID)
    {
        $solutioncomplaint = Complaint::where('complaint_ID', $complaint_ID)->first();
        $solutioncomplaint->complaint_solution = $request->complaint_solution;
        $solutioncomplaint->save(); 
        return redirect(route('complaint.show'));

    }
   
   

    public function destroy($complaint_ID)
    {
        Complaint::where('complaint_ID', $complaint_ID)->delete();
        return redirect()->back()->with('success', 'Complaint closed successfully!');
    }

    public function storeReport()
    { 
        // Fetch the complaint details from the database (replace 'YourModel' with your actual model)

        return view('ManageComplaint.complaintreport');
    }
    
    

}


