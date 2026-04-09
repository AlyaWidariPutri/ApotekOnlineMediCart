<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PelangganAuthMiddleware
{
    // public function handle($request, Closure $next)
    // {
    //     if (!session('pelanggan_id')) {
    //         return redirect()->route('pelanggan.login');
    //     }
    //     return $next($request);
    // }
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('pelanggan')->check()) {
            return redirect()->route('user.login');
        }
        return $next($request);
    }
}
