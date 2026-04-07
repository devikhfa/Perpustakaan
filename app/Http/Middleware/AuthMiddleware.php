<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Debug: cek session
        // dd(Session::all());
        
        // Cek apakah user sudah login
        if (!Session::has('user_id')) {
            Session::put('url_intended', $request->fullUrl());
            
            // Redirect ke halaman login dengan pesan
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman tersebut!');
        }
        
        return $next($request);
    }
}