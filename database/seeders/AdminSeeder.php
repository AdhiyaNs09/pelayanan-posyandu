<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            // Ambil instance Firebase Database menggunakan app()
            $database = app('firebase.database');

            // Data admin
            $adminData = [
                'flag' => 'admin', // Flag untuk admin
                'nik_orangtua' => '1234567890', // Contoh NIK admin
                'no_kk' => '1234567890', // Contoh KK admin
                'nomor' => '081234567890', // Nomor admin
            ];

            // Path ke data admin di Firebase
            $path = "users/1234567890";

            // Simpan data admin ke Firebase
            $database->getReference($path)->set($adminData);

            echo "Admin berhasil ditambahkan ke Firebase.\n";
        } catch (\Exception $e) {
            echo "Gagal menambahkan admin: " . $e->getMessage() . "\n";
        }
    }
}
