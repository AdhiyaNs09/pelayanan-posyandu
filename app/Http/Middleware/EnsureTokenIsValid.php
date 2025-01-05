<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $userRole = session('role');
        //Log::info('User role:', ['role' => session('role')]);


        // Pecah role menjadi array jika ada lebih dari satu
        $allowedRoles = explode('|', $roles);

        // Periksa apakah role pengguna ada dalam daftar
        if (!in_array($userRole, $allowedRoles)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
