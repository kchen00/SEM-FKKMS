<?php

namespace App\Http\Controllers;

use App\Models\rental;
use App\Http\Requests\StorerentalRequest;
use App\Http\Requests\UpdaterentalRequest;
use App\Models\application;
use App\Models\kiosk;
use App\Models\participant;
use Faker\Provider\ar_EG\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $participant = participant::where('user_ID', auth()->user()->user_ID)->first();
        $rental = rental::with('kiosk')
        ->where('parti_ID', $participant['parti_ID'])
        ->where('status', 'on going')
        ->first();
        // dd($rental);
        return view('manageRental.view', compact('rental'));
    }

    public function adminManage()
    {
        $applications = Application::orderBy('created_at', 'desc')->get();
        $rentals = Rental::orderByRaw("CASE WHEN status = 'on going' THEN 0 ELSE 1 END")
        ->orderBy('rentals_ID','desc')
        ->get();
        return view('manageRental.adminManage', compact('applications','rentals'));
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
        return view('manageRental.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        // $participant = participant::where('user_ID', auth()->user()->user_ID)->first();
        $rental = rental::find($id);
        // dd($rental);
        return view('manageRental.edit', compact('rental'));
      
    }

    public function adminEdit($id)
    {
        //
        $rental = rental::find($id);
        $kiosks = kiosk::where('rented',false)->get();
        // dd($rental);
        return view('manageRental.adminEdit', compact('rental','kiosks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $rental = rental::find($id);
       $rental->update($request->all());
       return redirect(route('rental'));
    }

    public function adminUpdate(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(application $application)
    {
        //
    }
}
