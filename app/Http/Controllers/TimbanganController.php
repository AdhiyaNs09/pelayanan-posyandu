<?php

namespace App\Http\Controllers;
use Kreait\Firebase\Contract\Database;

use Illuminate\Http\Request;

class TimbanganController extends Controller
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function index()
    {
        try {
            // Pastikan user sudah login
            if (!session('nik_orangtua')) {
                return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
            }

            $role = session('role'); // Role dari session
            $nikOrangtua = session('nik_orangtua'); // NIK Orang Tua dari session
            $allTimbangans = [];

            if ($role === 'admin') {
                // Jika admin, ambil semua data timbangan
                $users = $this->database->getReference('users')->getValue();

                if ($users) {
                    foreach ($users as $nik => $user) {
                        if (isset($user['datas'])) {
                            foreach ($user['datas'] as $anakKey => $anak) {
                                $histori = $anak['histori'] ?? [];

                                foreach ($histori as $tanggal => $data) {
                                    $allTimbangans[] = [
                                        'nama_anak' => $anak['nama_anak'] ?? '-',
                                        'berat_badan' => $data['berat_badan'] ?? '-',
                                        'tinggi_badan' => $data['tinggi_badan'] ?? '-',
                                        'tanggal_histori' => $tanggal,
                                        'nik_orangtua' => $nik,
                                        'anak_ke' => $anak['anak_ke'] ?? '-',
                                    ];
                                }
                            }
                        }
                    }
                }
            } elseif ($role === 'user') {
                // Jika user, hanya ambil data miliknya
                $path = "users/{$nikOrangtua}/datas";
                $userDatas = $this->database->getReference($path)->getValue();

                if ($userDatas) {
                    foreach ($userDatas as $anakKey => $anak) {
                        $histori = $anak['histori'] ?? [];

                        foreach ($histori as $tanggal => $data) {
                            $allTimbangans[] = [
                                'nama_anak' => $anak['nama_anak'] ?? '-',
                                'berat_badan' => $data['berat_badan'] ?? '-',
                                'tinggi_badan' => $data['tinggi_badan'] ?? '-',
                                'tanggal_histori' => $tanggal,
                                'nik_orangtua' => $nikOrangtua,
                                'anak_ke' => $anak['anak_ke'] ?? '-',
                            ];
                        }
                    }
                }
            }

            // Data untuk view
            $data = [
                'title' => 'Data Timbangan',
                'children' => $allTimbangans,
            ];

            return view('timbangan.index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data timbangan.');
        }
    }

    public function create()
    {
        // Ambil data dari Firebase
        $users = $this->database->getReference('users')->getValue();

        $anak = []; // Menampung data anak

        // Proses data anak dari Firebase
        if ($users) {
            foreach ($users as $nikOrangtua => $user) {
                if (isset($user['datas'])) {
                    foreach ($user['datas'] as $anakKey => $anakData) {
                        $anak[] = [
                            'id' => $anakKey, // Gunakan key anak sebagai ID
                            'nama' => $anakData['nama_anak'] ?? 'Tanpa Nama',
                            'nik_orangtua' => $nikOrangtua,
                        ];
                    }
                }
            }
        }

        // Kirim data ke view
        $data = [
            'title' => 'Tambah Timbangan',
            'anak' => $anak, // Kirim data anak
        ];

        return view('timbangan.create', compact('data', 'anak'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'anak_id' => 'required',
            'tanggal_timbangan' => 'required|date',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
        ]);

        // Ambil data dari request
        $anakId = $validated['anak_id'];
        $tanggalTimbangan = $validated['tanggal_timbangan'];
        $beratBadan = $validated['berat_badan'];
        $tinggiBadan = $validated['tinggi_badan'];

        // Ambil data anak dari Firebase
        $users = $this->database->getReference('users')->getValue();
        $nikOrangtua = null;

        foreach ($users as $nik => $user) {
            if (isset($user['datas'][$anakId])) {
                $nikOrangtua = $nik;
                break;
            }
        }

        // Periksa jika orang tua dan anak ditemukan
        if ($nikOrangtua === null) {
            return redirect()->back()->with('error', 'Anak tidak ditemukan.');
        }

        // Simpan data timbangan ke Firebase
        $timbanganRef = $this->database->getReference('users/' . $nikOrangtua . '/datas/' . $anakId . '/histori/' . $tanggalTimbangan);
        $timbanganRef->set([
            'berat_badan' => $beratBadan,
            'tinggi_badan' => $tinggiBadan,
        ]);

        // Redirect kembali dengan sukses
        return redirect('/timbangan')->with('success', 'Data timbangan berhasil disimpan.');
    }

    public function edit($nikOrangtua, $anak_ke, $tanggalTimbangan)
    {
        $data = [
            'title' => 'Edit Timbangan',
        ];
        // Sesuaikan key anak_id dengan nama "anak_ke_1"
        $anakRef = $this->database
        ->getReference("users/{$nikOrangtua}/datas/anak_ke_{$anak_ke}")
        ->getValue();
        $timbanganRef = $this->database
            ->getReference('users/' . $nikOrangtua . '/datas/anak_ke_' . $anak_ke . '/histori/' . $tanggalTimbangan)
            ->getValue();

        $selectedData = [
            'nik_orangtua' => $nikOrangtua,
            'anak_ke' => $anak_ke,
            'nama_anak' => $anakRef['nama_anak'] ?? '',
            'tanggal_timbangan' => $tanggalTimbangan,
            'berat_badan' => $timbanganRef['berat_badan'] ?? '',
            'tinggi_badan' => $timbanganRef['tinggi_badan'] ?? '',
        ];

       // dd($selectedData);
        return view('timbangan.edit', compact('selectedData', 'data'));
    }


    public function update(Request $request, $nikOrangtua, $anak_ke, $tanggalTimbangan)
    {
        // Validasi input
        $validatedData = $request->validate([
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
        ]);

        // Path data di Firebase
        $updatePath = "users/{$nikOrangtua}/datas/anak_ke_{$anak_ke}/histori/{$tanggalTimbangan}";

        // Data yang akan diperbarui
        $updateData = [
            'berat_badan' => $validatedData['berat_badan'],
            'tinggi_badan' => $validatedData['tinggi_badan'],
        ];

        // Update ke Firebase
        $this->database->getReference($updatePath)->update($updateData);

        // Redirect dengan pesan sukses
        return redirect('timbangan')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($nikOrangtua, $anak_ke, $tanggalTimbangan)
    {
        try {
            $deletePath = "users/{$nikOrangtua}/datas/anak_ke_{$anak_ke}/histori/{$tanggalTimbangan}";
            $this->database->getReference($deletePath)->remove();
            return redirect('timbangan')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('timbangan')->with('error', 'Data tidak ditemukan!');
        }
    }

}
