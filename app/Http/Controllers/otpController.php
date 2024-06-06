<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class OtpController extends Controller
{
    public function showMobileForm()
    {
        return view('ManageUser.enter-mobile');
    }

    public function sendSMS(Request $request)
{
    // Validate the phone number
    $request->validate([
        'phone' => 'required|numeric|digits_between:10,11', // assuming phone number length for Malaysia
    ]);

    // Retrieve and format the phone number
    $phoneNumber = $request->phone;
    $formattedPhoneNumber = '+60' . substr($phoneNumber, 1);

    // Generate a random OTP
    $otp = mt_rand(100000, 999999);

    // Your Twilio credentials
    $sid = env('TWILIO_ACCOUNT_SID');
    $token = env('TWILIO_AUTH_TOKEN');
    $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');

    try {
        // Initialize Twilio client
        $client = new \Twilio\Rest\Client($sid, $token);

        // Send SMS with OTP
        $client->messages->create(
            $formattedPhoneNumber,
            [
                'from' => $twilioPhoneNumber,
                'body' => "Your OTP for password reset is: $otp",
            ]
        );

        // Store the OTP and phone number in session for later verification
        Session::put('otp', $otp);
        Session::put('phone', $phoneNumber);

        // Redirect to OTP verification page with success message
        return redirect()->route('otp.verification')->with('status', 'OTP sent successfully!');
    } catch (\Exception $e) {
        // Redirect back with an error message
        return back()->withErrors(['phone' => 'Unable to send OTP. Please try again later.']);
    }
}


    public function showVerificationForm()
    {
        return view('ManageUser.otp-verification');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $enteredOtp = $request->otp;
        $sessionOtp = Session::get('otp');
        $phone = Session::get('phone');

        if ($enteredOtp == $sessionOtp) {
            // Clear OTP from session
            Session::forget('otp');
            // Find the user by phone number
            $user = User::where('phone_num', $phone)->first();

            if ($user) {
                // Redirect to change password page
                return redirect()->route('change-password');
            } else {
                return back()->withErrors(['phone' => 'Phone number not found.']);
            }
        } else {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }
    }
}
