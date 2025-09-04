<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('aems.maintenance.mode') && !$request->is('admin/*') && !Auth::check()) {
            return response()->view('maintenance', [
                'message' => config('aems.maintenance.message')
            ], 503);
        }

        return $next($request);
    }
}
