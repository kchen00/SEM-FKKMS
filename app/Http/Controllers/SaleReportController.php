<?php

namespace App\Http\Controllers;

use App\Models\sale_report;
use App\Http\Requests\Storesale_reportRequest;
use App\Http\Requests\Updatesale_reportRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SaleReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::getUser();
        if($user->role == 'student') {
            return view('ManageReport.ParticipantView');
        } else if ($user->role == 'pp_admin'){
            return view('ManageReport.PPView');
        }

        return abort(404);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storesale_reportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(sale_report $sale_report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sale_report $sale_report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatesale_reportRequest $request, sale_report $sale_report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sale_report $sale_report)
    {
        //
    }
}
