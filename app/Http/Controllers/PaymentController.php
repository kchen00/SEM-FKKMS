<?php

namespace App\Http\Controllers;

use App\Models\payment;
use App\Http\Requests\StorepaymentRequest;
use App\Http\Requests\UpdatepaymentRequest;
use App\Models\Participant;
use App\Models\rental_fees;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $participant = Participant::where('user_ID', auth()->user()->user_ID)->first();
        $payments = payment::where('parti_ID',$participant->parti_ID)->get();
        $total = 0;
        $totalRent = 0;
        $pendingPayment = 0;
        $monthlyRents = rental_fees::where('parti_ID',$participant->parti_ID)->get();
        foreach($monthlyRents as $monthlyRent){
            $totalRent = $totalRent + $monthlyRent->amount;
        }
        foreach($payments as $payment){
            if($payment->status == 'accepted'){
                $total = $total + $payment->amount;
            }
            if($payment->status == 'received' || $payment->status == 'on review'){
                $pendingPayment = $pendingPayment + $payment->amount;
            }
        }
        $datas = [
            'total' => $total,
            'totalRent' => $totalRent,
            'balance' => $totalRent - $total,
            'pendingPayment' => $pendingPayment,
        ];


        return view('managePayment.manage', compact('payments', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('managePayment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $participant = Participant::where('user_ID', auth()->user()->user_ID)->first();
        $request->merge([
            'parti_ID' => $participant->parti_ID,
            'status' => 'received',
        ]);
        // dd($request->all());
        $payment = payment::create($request->all());
        // dd($payment);
        return redirect(route('payment'));
        
    }

    /**
     * Display the specified resource.
     */
    public function show(payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepaymentRequest $request, payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payment $payment)
    {
        //
    }

    public function bursaryManage()
    {
        // $payments = payment::get()->with('participant')->sortBy('status');
        $payments = Payment::with('participant.user')->orderBy('status')->get();
// dd($payments);
        return view('managePayment.bursaryManage',compact('payments'));

    }
}
