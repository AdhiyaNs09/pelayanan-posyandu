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
    public function index(){
        // Path Firebase untuk mengambil semua data anak
        $users = $this->database->getReference('users')->getValue();

        $allChildren = [];
        foreach ($users as $nik_orangtua => $userData) {
            if (isset($userData['datas'])) {
                foreach ($userData['datas'] as $key => $child) {
                    $allChildren[] = array_merge($child, ['nik_orangtua' => $nik_orangtua]);
                }
            }
        }

        // Data untuk view
        $data = [
            'title' => 'Data Anak',
            'children' => $allChildren,
        ];
        //dd($data['children']);
        return view('anak.index', compact('data'));
    }
    public function create(){
        $data=[
            'title' => 'Tambah Data Anak'
        ];
        return view('anak.create', compact('data'));
    }

    public function store(Request $request){

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

        $data = [
            'nik_anak' => $request->nik_anak,
            'nama_anak' => $request->nama_anak,
            'anak_ke' => $request->anak_ke,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tgl_lahir,
            'berat_badan' => null,
            'tinggi_badan' => null,
        ];

        try {
            //Path ke data anak di Firebase
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

            // Redirect dengan pesan sukses jika operasi berhasil
            return redirect('/anak')->with('success', 'Data anak berhasil disimpan.');
        } catch (\Exception $e) {
            // Tangkap error dan redirect dengan pesan error
            return redirect('/anak')->with('error', 'Data anak gagal disimpan. Kesalahan: ' . $e->getMessage());
        }

    }
}
