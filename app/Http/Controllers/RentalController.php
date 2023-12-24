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
        ->where('parti_ID', $participant['parti_ID'])->first();
        // dd($rental);
        return view('manageRental.view', compact('rental'));
    }

    public function adminManage()
    {
        $applications = Application::orderBy('created_at', 'desc')->get();
        $rentals = rental::orderby('status')->get();
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
    public function edit(Request $request, $id)
    {
        //
        $application = application::where('application_ID', $id)->first();
        return view('manageRental.edit', compact('application'));
    }

    public function adminEdit(Request $request, $id)
    {
        //
        $application = application::where('application_ID', $id)->first();
        $status = [
            'status' => 'on review'
        ];
        $kiosks = kiosk::where('rented', false)->get();
        $application->update($status);
        return view('manageRental.adminEdit', compact('application', 'kiosks'));
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
        if ($application->status === 'accepted') {
            // $kiosk = [
            // ];
            $application->status = 'on going';
            $application->merge([
                'kiosk_ID' => $request->kiosk,
            ]);
            $rental = rental::create($application->all());
            // dd($kiosk);
        }
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
