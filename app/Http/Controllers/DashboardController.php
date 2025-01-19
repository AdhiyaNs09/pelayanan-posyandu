<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Pastikan user sudah login
        if (!session('nik_orangtua')) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil role dari session
        $role = session('role');
        $database = app('firebase.database');

        $jumlahAnak = 0;
        $jumlahTimbangan = 0;

        if ($role === 'admin') {
            // Jika role adalah admin, ambil semua data anak dan timbangan
            $usersPath = "users";
            $allUsers = $database->getReference($usersPath)->getValue();

            if ($allUsers) {
                foreach ($allUsers as $user) {
                    if (isset($user['datas'])) {
                        foreach ($user['datas'] as $anak) {
                            $jumlahAnak++;
                            if (isset($anak['histori'])) {
                                $jumlahTimbangan += count($anak['histori']);
                            }
                        }
                    }
                }
            }
        } elseif ($role === 'user') {
            // Jika role adalah user, ambil data berdasarkan nik_orangtua
            $nikOrangtua = session('nik_orangtua');
            $path = "users/{$nikOrangtua}/datas";
            $anakData = $database->getReference($path)->getValue();

            if ($anakData) {
                foreach ($anakData as $anak) {
                    $jumlahAnak++;
                    if (isset($anak['histori'])) {
                        $jumlahTimbangan += count($anak['histori']);
                    }
                }
            }
        }

        // Kirim data ke view
        $data = [
            'title' => 'Dashboard',
            'jumlahAnak' => $jumlahAnak,
            'jumlahTimbangan' => $jumlahTimbangan,
        ];

        return view('dashboard.index', compact('data'));
    }
}
