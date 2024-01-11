<?php

namespace App\Http\Middleware;

use App\Models\Application;
use App\Models\Participant;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CheckApplication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role == "student"||Auth::user()->role == "vendor") {
            // Replace 'column_name' with the actual column name and 'value' with the expected value
            $application = Application::where("parti_ID", $this->get_participant_ID())->latest('created_at')->first();
            if (!$application) {
                // If no matching record is found, redirect to 'application.manage'
                return redirect()->route('application.manage');
            }
            else {
                if($application->status != "accepted") {
                    // If applicatio is not accepted, redirect to 'application.manage'
                    return redirect()->route('application.manage');
                }
            }
        }

        return $next($request);
    }

    // function to get the participant ID
    public function get_participant_ID()
    {
        $participant = Participant::where('user_ID', Auth::user()->user_ID)->get()->first();
        return $participant->parti_ID;
    }
}
