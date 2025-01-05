<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Login',
        ];
        return view('login', compact('data'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'no_kk' => 'required',
            'nik_orangtua' => 'required',
        ]);

        $database = app('firebase.database');
        $path = "users/{$request->nik_orangtua}";
        $data = $database->getReference($path)->getValue();

        try {
            // Cek apakah data ditemukan di Firebase
            if ($data && $data['no_kk'] == $request->no_kk) {
                // Simpan data ke session
                session([
                    'nik_orangtua' => $request->nik_orangtua,
                    'role' => $data['flag'], // role: admin atau user
                ]);

                return redirect('/dashboard')->with('success', 'Login Berhasil');
            } else {
                return redirect('/')->with('error', 'No KK atau NIK Orang Tua Salah');
            }
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'No KK atau NIK Orang Tua Salah');
        }
    }

    public function logout()
    {
        // Hapus session
        session()->flush();
        return redirect('/')->with('success', 'Logout Berhasil');
    }
}
