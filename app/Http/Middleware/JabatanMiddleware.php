<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class JabatanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$jabatans
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$jabatan)
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login'); 
        }

        if (!in_array(auth()->user()->jabatan, $jabatan)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}