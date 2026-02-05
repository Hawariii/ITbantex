<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Middleware ini memastikan hanya user ADMIN yang bisa akses route admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kalau user belum login → redirect ke login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login dulu.');
        }

        // Kalau user login tapi bukan admin → forbidden
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Khusus admin.');
        }

        // Kalau admin → lanjut
        return $next($request);
    }
}