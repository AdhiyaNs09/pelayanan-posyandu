<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next): Response
    {
        $user = Session::get('user');

        if (!$user || $user['flag'] !== 'admin') {
            return redirect('/')->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
