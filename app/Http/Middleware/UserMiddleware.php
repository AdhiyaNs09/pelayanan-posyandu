<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next): Response
    {
        $user = Session::get('user');

        if (!$user || $user['flag'] !== 'user') {
            return redirect('/')->with('error', 'Hanya pengguna yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
