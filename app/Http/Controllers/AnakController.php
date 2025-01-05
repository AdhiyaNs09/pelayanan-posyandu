<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Validator;

class AnakController extends Controller
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function index()
    {
        try {
            // Path Firebase untuk mengambil semua data anak
            $users = $this->database->getReference('users')->getValue();

            $allChildren = [];
            if ($users) {
                foreach ($users as $nik_orangtua => $userData) {
                    if (isset($userData['datas'])) {
                        foreach ($userData['datas'] as $key => $child) {
                            $allChildren[] = array_merge($child, ['nik_orangtua' => $nik_orangtua]);
                        }
                    }
                }
            }

            // Data untuk view
            $data = [
                'title' => 'Data Anak',
                'children' => $allChildren,
            ];
          // dd($data);
            return view('anak.index', compact('data'));
        } catch (\Throwable $th) {
            // Tangani kesalahan jika terjadi masalah serius seperti koneksi Firebase
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data anak.');
        }
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Data Anak'
        ];
        return view('anak.create', compact('data'));
    }

    public function store(Request $request)
    {
        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'no_kk' => 'required|numeric',
            'nik_orangtua' => 'required|numeric',
            'nama_orangtua' => 'required|string|max:255',
            'nomor_hp' => 'required|numeric',
            'nama_anak' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'nik_anak' => 'required|numeric',
            'anak_ke' => 'required|numeric',
            'alamat' => 'required|string|max:255',
        ], [
            'no_kk.required' => 'Nomor Kartu Keluarga wajib diisi.',
            'no_kk.numeric' => 'Nomor Kartu Keluarga harus berupa angka.',
            'nik_orangtua.required' => 'NIK Orangtua wajib diisi.',
            'nik_orangtua.numeric' => 'NIK Orangtua harus berupa angka.',
            'nama_orangtua.required' => 'Nama Orangtua wajib diisi.',
            'nama_orangtua.string' => 'Nama Orangtua harus berupa teks.',
            'nama_orangtua.max' => 'Nama Orangtua tidak boleh lebih dari 255 karakter.',
            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'nama_anak.required' => 'Nama Anak wajib diisi.',
            'jenis_kelamin.required' => 'Jenis Kelamin wajib diisi.',
            'nik_anak.required' => 'NIK Anak wajib diisi.',
            'anak_ke.required' => 'Kolom Anak Ke wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Data untuk anak yang akan disimpan
        $data = [
            'nama_orangtua' => $request->nama_orangtua,
            'nik_anak' => $request->nik_anak,
            'nama_anak' => $request->nama_anak,
            'anak_ke' => $request->anak_ke,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tgl_lahir,
        ];

        try {
            // Path ke data anak di Firebase
            $path = "users/{$request->nik_orangtua}/datas/anak_ke_{$request->anak_ke}";

            // Simpan data anak ke Firebase
            $this->database->getReference($path)->set($data);

            // Buat akun orang tua jika belum ada
            $parentData = [
                'flag' => 'user',
                'no_kk' => $request->no_kk,
                'nik_orangtua' => $request->nik_orangtua,
                'nomor' => $request->nomor_hp,
            ];
            $this->database->getReference("users/{$request->nik_orangtua}")->update($parentData);

            // Cek apakah histori sudah ada
            $historiPath = "{$path}/histori";
            $existingHistori = $this->database->getReference($historiPath)->getValue();

            if (empty($existingHistori)) {
                // Jika histori belum ada, buat histori default
                $currentDate = now(); // Tanggal saat ini
                $nextMonth = $currentDate->copy()->addMonth(); // Tanggal satu bulan ke depan
                $historiData = [
                    $currentDate->format('Y-m-d') => [
                        'berat_badan' => 0,
                        'tinggi_badan' => 0,
                    ],
                ];

                // Simpan histori ke Firebase
                $this->database->getReference($historiPath)->set($historiData);
            }

            // Redirect dengan pesan sukses jika operasi berhasil
            return redirect('/anak')->with('success', 'Data anak berhasil disimpan.');
        } catch (\Exception $e) {
            // Tangkap error dan redirect dengan pesan error
            return redirect('/anak')->with('error', 'Data anak gagal disimpan. Kesalahan: ' . $e->getMessage());
        }
    }


    public function edit($nik_orangtua, $anak_ke)
    {
        try {
            $path = "users/{$nik_orangtua}/datas/anak_ke_{$anak_ke}";
            $childData = $this->database->getReference($path)->getValue();

            if (!$childData) {
                return redirect('/anak')->with('error', 'Data anak tidak ditemukan.');
            }

            $data = [
                'title' => 'Edit Data Anak',
                'child' => $childData,
                'nik_orangtua' => $nik_orangtua,
                'anak_ke' => $anak_ke,
            ];

            return view('anak.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect('/anak')->with('error', 'Data anak tidak ditemukan.');
        }
    }




    public function update(Request $request, $nik_orangtua, $anak_ke)
    {
        $validator = Validator::make($request->all(), [
            'nama_anak' => 'required|string|max:255',
            'anak_ke' => 'required|numeric',
            'alamat' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tanggal_lahir' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updatedData = [
            'nama_anak' => $request->nama_anak,
            'anak_ke' => $request->anak_ke,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
        ];

        try {
            // Path ke data anak di Firebase
            $path = "users/{$nik_orangtua}/datas/anak_ke_{$anak_ke}";

            // Update data di Firebase
            $this->database->getReference($path)->update($updatedData);

            return redirect('/anak')->with('success', 'Data anak berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect('/anak')->with('error', 'Gagal memperbarui data anak: ' . $e->getMessage());
        }
    }

    public function show($nik_orangtua, $anak_ke)
    {
        $path = "users/{$nik_orangtua}/datas/anak_ke_{$anak_ke}";
        $paths = $this->database->getReference($path)->getValue();

        if (!$paths) {
            return redirect('/anak')->with('error', 'Data anak tidak ditemukan.');
        }

        // Ambil data histori
        $histori = $paths['histori'] ?? [];

        // Format data untuk grafik (opsional)
        $chartData = [
            'weights' => [],
            'heights' => [],
        ];
        foreach ($histori as $tanggal => $data) {
            $chartData['weights'][] = [
                'x' => strtotime($tanggal) * 1000, // Format timestamp untuk JavaScript
                'y' => $data['berat_badan'],
            ];
            $chartData['heights'][] = [
                'x' => strtotime($tanggal) * 1000,
                'y' => $data['tinggi_badan'],
            ];
        }

        $data = [
            'title' => 'Detail Data Anak',
            'child' => $paths,
            'histori' => $histori,
            'chartData' => $chartData,
        ];

        return view('anak.detail', compact('data'));
    }


    public function destroy($nik_orangtua, $anak_ke)
    {
        try {
            // Path Firebase ke node datas
            $datasPath = "users/{$nik_orangtua}/datas";
            $childPath = "{$datasPath}/anak_ke_{$anak_ke}";

            // Ambil semua data anak untuk nik_orangtua
            $datas = $this->database->getReference($datasPath)->getValue();

            if ($datas && count($datas) === 1) {
                // Jika hanya ada satu data anak, hapus seluruh node orang tua
                $this->database->getReference("users/{$nik_orangtua}")->remove();
            } else {
                // Jika ada lebih dari satu anak, hapus hanya anak yang ditentukan
                $this->database->getReference($childPath)->remove();
            }

            return redirect('/anak')->with('success', 'Data anak berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/anak')->with('error', 'Data anak gagal dihapus. Kesalahan: ' . $e->getMessage());
        }
    }


}
