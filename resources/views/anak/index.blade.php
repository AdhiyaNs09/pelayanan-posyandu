@extends('layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Master Data Anak</h4>
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <a href="{{ url('tambah-anak') }}" class="btn btn-sm btn-primary float-end">Tambah Data</a>
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
                                            <th>ID</th>
                                            <th>Nama Anak</th>
                                            <th>Nama Orangtua</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Alamat</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['children'] as $index => $child)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $child['nama_anak'] ?? '-' }}</td>
                                                <td>{{ $child['nama_orangtua'] ?? '-' }}</td>
                                                <td>{{ $child['jenis_kelamin'] ?? '-' }}</td>
                                                <td>{{ $child['alamat'] ?? '-' }}</td>
                                                <td>{{ $child['tanggal_lahir'] ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ url('edit-anak/' . $child['nik_orangtua'] . '/' . $child['anak_ke']) }}" class="btn btn-xs btn-primary">Edit</a>
                                                    <a href="{{ url('detail-anak/' . $child['nik_orangtua'] . '/' . $child['anak_ke']) }}" class="btn btn-xs btn-success">Lihat</a>
                                                    <form action="{{ url('hapus-anak/' . $child['nik_orangtua'] . '/' . $child['anak_ke']) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
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
