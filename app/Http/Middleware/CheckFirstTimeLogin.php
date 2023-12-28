<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckFirstTimeLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $affected_roles = ["admin", "pp_admin", "bursary", "tech_team"];
        if (Auth::check() && Auth::user()->created_at == Auth::user()->updated_at && in_array(Auth::user()->role, $affected_roles)) {
            // It's the first login, redirect to the desired page
            return redirect()->route('admin-force-reset');
        }

        return $next($request);
    }
}
