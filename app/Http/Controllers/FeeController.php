<?php

namespace App\Http\Controllers;

use App\Models\Fee_rate;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    //
    public function edit(){
        $student = Fee_rate::where('type', 'student')->first();
        $vendor = Fee_rate::where('type', 'vendor')->first();
        return view('ManageFee.edit', compact('student', 'vendor'));
    }

    public function update(Request $request){
        $student = Fee_rate::where('type','student')->first();
        if ($student) {
            $student->amount = $request->student;
            $student->save();
        }
        
        $vendor = Fee_rate::where('type','vendor')->first();
        if ($vendor) {
            $vendor->amount = $request->vendor;
            $vendor->save();
        }
        
        return redirect(route('fee'));
    }
}
