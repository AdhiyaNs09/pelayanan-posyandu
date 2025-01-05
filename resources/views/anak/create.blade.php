@extends('layouts.master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">
            <div class="row">
                <!-- <div class="col-md-20"> -->
                <div class="card">
                    <div class="card-header">
                        <h4> Tambah Anak
                            <a href="{{ url('anak') }}" class="btn btn-sm btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('tambah-anak') }}" method="POST">
                            @csrf

                            <div class="form group mb-3">
                                <label>Nomor Kartu Keluarga</label>
                                <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk') }}">
                                @error('no_kk')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label>Nama Orangtua</label>
                                <input type="text" name="nama_orangtua" class="form-control"
                                    value="{{ old('nama_orangtua') }}">
                                @error('nama_orangtua')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form group mb-3">
                                <label>NIK Orangtua</label>
                                <input type="text" name="nik_orangtua" class="form-control"
                                    value="{{ old('nik_orangtua') }}">
                                @error('nik_orangtua')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form group mb-3">
                                <label>No HP Orangtua</label>
                                <input type="text" name="nomor_hp" class="form-control" value="{{ old('nomor_hp') }}">
                                @error('nomor_hp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form group mb-3">
                                <label>NIK Anak</label>
                                <input type="text" name="nik_anak" class="form-control" value="{{ old('nik_anak') }}">
                                @error('nik_anak')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form group mb-3">
                                <label>Nama Anak</label>
                                <input type="text" name="nama_anak" class="form-control" value="{{ old('nama_anak') }}">
                                @error('nama_anak')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form group mb-3">
                                <label>Anak Ke</label>
                                <input type="text" name="anak_ke" class="form-control" value="{{ old('anak_ke') }}">
                                @error('anak_ke')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form group mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" value="{{ old('tgl_lahir') }}">
                                @error('tgl_lahir')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form group mb-3">
                                <label>Berat Badan Anak</label>
                                <input type="text" name="berat_badan" class="form-control" disabled>
                            </div>
                            <div class="form group mb-3">
                                <label>Tinggi Anak</label>
                                <input type="text" name="tinggi_badan" class="form-control" disabled>
                            </div>
                            <div class="form group mb-3">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}">
                                @error('alamat')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form group mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- <script>
        document.getElementById('adminRegistrationForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(event.target);

            firebase.database().ref('users').push({
                // ... data user ...
                'is_admin': formData.get('is_admin') === '1',
            });

            firebase.database().ref('tblm_anak').push({
                // ... data anak ...
            });

            // ... logika lainnya setelah pendaftaran ...
        });
    </script> --}}
@endsection
