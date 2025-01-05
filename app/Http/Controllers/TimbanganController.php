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
        $users = $this->database->getReference('users')->getValue();

        $data = [
            'title' => 'Timbangan',
            'children' => []
        ];

        if ($users) {
            foreach ($users as $nikOrangtua => $user) {
                if (isset($user['datas'])) {
                    foreach ($user['datas'] as $anakKey => $anakData) {
                        $histori = $anakData['histori'] ?? [];

                        foreach ($histori as $tanggal => $detail) {
                            $data['children'][] = [
                                'nama_anak' => $anakData['nama_anak'] ?? '-',
                                'berat_badan' => $detail['berat_badan'] ?? '-',
                                'tinggi_badan' => $detail['tinggi_badan'] ?? '-',
                                'tanggal_histori' => $tanggal ?? '-',
                                'nik_orangtua' => $nikOrangtua,
                                'anak_ke' => $anakData['anak_ke'] ?? '-',
                            ];
                        }
                    }
                }
            }
        }
        //dd($data['children']);
        return view('timbangan.index', compact('data'));
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
        return redirect()->back()->with('success', 'Data timbangan berhasil disimpan.');
    }


}
