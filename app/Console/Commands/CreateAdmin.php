<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {nik_orangtua} {no_kk} {nomor}';
    protected $description = 'Create an admin account in Firebase';

    public function handle()
    {
        $nik_orangtua = $this->argument('nik_orangtua');
        $no_kk = $this->argument('no_kk');
        $nomor = $this->argument('nomor');

        try {
            // Ambil instance Firebase Database
            $database = app('firebase.database');

            // Data admin
            $adminData = [
                'flag' => 'admin', // Flag untuk admin
                'nik_orangtua' => $nik_orangtua,
                'no_kk' => $no_kk,
                'nomor' => $nomor,
            ];

            // Path ke data admin di Firebase
            $path = "users/{$nik_orangtua}";

            // Simpan data admin ke Firebase
            $database->getReference($path)->set($adminData);

            $this->info("Admin berhasil dibuat dengan NIK: {$nik_orangtua}");
        } catch (\Exception $e) {
            $this->error("Gagal membuat admin: " . $e->getMessage());
        }
    }
}
