@extends('layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Timbangan Anak</h4>
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <a href="{{ url('tambah-timbangan') }}" class="btn btn-sm btn-primary float-end">Tambah Data</a>

                    </div>

                    <div class="container">
                        <!-- Filter Form -->
                        <form method="GET" action="{{ url()->current() }}">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="month" class="form-label">Bulan</label>
                                    <select id="month" name="month" class="form-select">
                                        <option value="">Pilih Bulan</option>
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}"
                                                {{ request('month') == $month ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $month, 10)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="year" class="form-label">Tahun</label>
                                    <select id="year" name="year" class="form-select">
                                        <option value="">Pilih Tahun</option>
                                        @foreach (range(date('Y'), 2000) as $year)
                                            <option value="{{ $year }}"
                                                {{ request('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        @if (count($data['children']) == 0)
                            <div class="alert alert-info">
                                Tidak ada data anak yang ditemukan.
                            </div>
                        @else
                            <div class="card-datatable table-responsive">
                                <table class="datatables-basic table border-top" id="tabeldata">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Anak</th>
                                            <th>Berat Badan</th>
                                            <th>Tinggi Badan</th>
                                            <th>Tanggal Badan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['children'] as $index => $child)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $child['nama_anak'] }}</td>
                                                <td>{{ $child['berat_badan'] }}</td>
                                                <td>{{ $child['tinggi_badan'] }}</td>
                                                <td>{{ $child['tanggal_histori'] }}</td>
                                                <td>
                                                    <a href="{{ url('edit-timbangan/' . $child['nik_orangtua'] . '/' . $child['anak_ke']) }}"
                                                        class="btn btn-xs btn-primary">Edit</a>
                                                    {{-- <a href="{{ url('detail-anak/' . $child['nik_orangtua'] . '/' . $child['anak_ke']) }}"
                                                        class="btn btn-xs btn-success">Lihat</a> --}}
                                                    <form
                                                        action="{{ url('hapus-timbangan/' . $child['nik_orangtua'] . '/' . $child['anak_ke']) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-xs btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
