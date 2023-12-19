<?php

namespace App\Http\Controllers;

use App\Models\sale_report;
use App\Http\Requests\Storesale_reportRequest;
use App\Http\Requests\Updatesale_reportRequest;
use App\Models\Participant;
use App\Models\User;
use App\Policies\SaleReportPolicy;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SaleReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::getUser();
        $role = $user->role;
        if ($role == 'student' or $role == "vendor") {
            return view('ManageReport.ShowReport', ['role' => $role, 'sales_data' => $this->show()]);
        } else if ($role == 'pp_admin') {
            return view('ManageReport.SelectKIOSK');
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
        $validatedData = $request->validate([
            'sale_input' => 'required|numeric|between:0.01,9999.99',
        ]);
        // Create a new SaleReport model instance and assign validated data
        $saleReport = new sale_report();
        $saleReport->parti_ID = $this->get_participant_ID();
        $saleReport->sales = $validatedData['sale_input'];
        $saleReport->comment = "";

        // Save the model to the database
        $saleReport->save();

        return redirect()->route('show-report');
    }

    /**
     * get the sale report of the participant
     */
    public function show()
    {
        $parti_ID = $this->get_participant_ID();
        $sale_data = [];

        // Fetch sales data for each month from January to December
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT); // Format month with leading zero
            $date = Carbon::create(null, $i, 1); // Create Carbon instance for the month

            // Fetch sales data for the current month
            $sales = sale_report::where('parti_ID', $parti_ID)
                ->whereMonth('created_at', $month)
                ->get();

            // Store sales data for the month in the $salesData array
            $sale_data[$date->format('F')] = $sales; // Use month name as array key

        }

        return $sale_data;
    }

    // function to retreive KISOK id and KIOSK owner from the database
    public function get_kisok_id_owner()
    {
    }

    // function to get the participant ID
    public function get_participant_ID()
    {
        $participant = Participant::where('user_ID', Auth::user()->user_ID)->get()->first();
        return $participant->parti_ID;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sale_report $sale_report)
    {
        dd($sale_report);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatesale_reportRequest $request, sale_report $sale_report)
    {
        $report = sale_report::findOrFail($request["report_ID"]);
        // Update the sale data
        $report->sales = $request->input('sale_input');
        // Update other fields as needed

        $report->save();
        return redirect()->route('show-report');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sale_report $sale_report)
    {
        //
    }

    // function to add comment by PUPUK admin
    public function add_comment()
    {
    }

    // function to edit comment by PUPUK admin
    public function edit_comment()
    {
    }

    // function to show comment by pupuk admin
    public function show_commnet()
    {
    }
}
