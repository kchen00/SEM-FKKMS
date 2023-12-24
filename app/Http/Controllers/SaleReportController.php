<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storesale_reportRequest;
use App\Http\Requests\Updatesale_reportRequest;
use App\Models\Participant;
use App\Models\rental;
use App\Models\Sale_report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class SaleReportController extends Controller
{
    // show the sale report to participants
    public function index()
    {
        $user = Auth::getUser();
        $role = $user->role;
        $participant_id = $this->get_participant_ID();

        return view('ManageReport.ShowReport', ['role' => $role, 'sales_data' => $this->show($participant_id), 'total_sales' => $this->get_total_sales($participant_id), 'average_sales'=>$this->get_average_sales($participant_id)]);
    }

    // show the sale report to pupuk admin of selected participant
    public function admin_index(int $participant_id, string $kiosk_id, string $kiosk_owner)
    {
        $user = Auth::getUser();
        $role = $user->role;

        $sale_data = $this->show($participant_id);

        return view('ManageReport.ShowReport', ['role' => $role, 'total_sales' => $this->get_total_sales($participant_id), 'average_sales'=>$this->get_average_sales($participant_id), 'sales_data' => $sale_data, 'kiosk_id'=>$kiosk_id, 'kiosk_owner'=>$kiosk_owner]);
    }

    public function get_total_sales(int $partiID) {
        $total_sales = Sale_report::where('parti_ID', $partiID)
                             ->sum('sales');

        // Use $totalSales variable as needed
        return number_format($total_sales, 2);

    }

    public function get_average_sales(int $partiID)
    {
        $average_sales = Sale_report::where('parti_ID', $partiID)
                                ->avg('sales');

        
        return number_format($average_sales, 2);
    }

    // show a list of kiosk to pupuk admin
    public function show_kiosk()
    {
        return view('ManageReport.SelectKIOSK', ["kiosk_id_owner" => $this->get_kisok_id_owner()]);
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
            "date" => "required",
        ]);
        // Create a new SaleReport model instance and assign validated data
        $saleReport = new sale_report();
        $saleReport->parti_ID = $this->get_participant_ID();
        $saleReport->sales = $validatedData['sale_input'];
        $saleReport->created_at = $validatedData['date'];
        $saleReport->updated_at = $validatedData['date'];
        $saleReport->comment = "";

        // Save the model to the database
        $saleReport->save();

        return redirect()->route('show-report');
    }

    /**
     * get the sale report of the participant
     */
    public function show(int $parti_ID)
    {
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
        // Retrieve kiosk_ID, parti_ID, and username data from the rentals table
        $rentalsData = Rental::with('participant.user')->select('kiosk_ID', 'parti_ID')->get();

        $kiosk_id_owner = [];

        // Access the retrieved data and build the kiosk_id_owner array
        foreach ($rentalsData as $rental) {
            $kioskId = $rental->kiosk_ID;
            $partiId = $rental->parti_ID;
            $participant = $rental->participant;

            if ($participant) {
                $user = $participant->user;

                if ($user) {
                    $username = $user->username;
                    // Store kiosk_id, parti_id, and username in the array
                    $kiosk_id_owner[$kioskId] = [
                        'parti_id' => $partiId,
                        'username' => $username
                    ];
                }
            }
        }


        return $kiosk_id_owner;
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
    public function add_comment(Request $request)
    {
        $validatedData = $request->validate([
            'pp_comment' => 'required',
            "report_ID" => 'required'
        ]);

        $newComment = $validatedData["pp_comment"];
        $report_id = $validatedData["report_ID"];
        Sale_report::where('report_id', $report_id)
            ->update(['comment' => $newComment]);

        return back();
    }

    // function to edit comment by PUPUK admin
    public function edit_comment()
    {
    }

}
