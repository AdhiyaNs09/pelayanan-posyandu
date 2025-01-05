@extends('layouts.master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">
            <div class="row">
                <!-- <div class="col-md-20"> -->
                <div class="card">
                    <div class="card-header">
                        <h4> Edit Anak
                            <a href="{{ url('anak') }}" class="btn btn-sm btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('update-anak/' . $data['nik_orangtua'] . '/' . $data['child']['anak_ke']) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form group mb-3">
                                <label>NIK Anak</label>
                                <input type="text" name="nik_anak" class="form-control"
                                    value="{{ $data['child']['nik_anak'] }}" disabled>
                            </div>
                            <div class="form group mb-3">
                                <label>Nama Anak</label>
                                <input type="text" name="nama_anak" class="form-control"
                                    value="{{ $data['child']['nama_anak'] }}">
                                @error('nama_anak')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form group mb-3">
                                <label>Anak Ke</label>
                                <input type="text" name="anak_ke" class="form-control"
                                    value="{{ $data['child']['anak_ke'] }}">
                                @error('anak_ke')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form group mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control"
                                    value="{{ $data['child']['tanggal_lahir'] }}">
                                @error('tanggal_lahir')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki"
                                        {{ $data['child']['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="Perempuan"
                                        {{ $data['child']['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                                @error('jenis_kelamin')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form group mb-3">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control"
                                    value="{{ $data['child']['alamat'] }}">
                                @error('alamat')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form group mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
