@extends('layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Anak
                            <a href="{{ url('anak') }}" class="btn btn-sm btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4"><strong>Nama Orangtua</strong></div>
                            <div class="col-md-8">: {{ $data['child']['nama_orangtua'] ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Nama Anak</strong></div>
                            <div class="col-md-8">: {{ $data['child']['nama_anak'] ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>NIK Anak</strong></div>
                            <div class="col-md-8">: {{ $data['child']['nik_anak'] ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Jenis Kelamin</strong></div>
                            <div class="col-md-8">: {{ $data['child']['jenis_kelamin'] ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Tanggal Lahir</strong></div>
                            <div class="col-md-8">: {{ $data['child']['tanggal_lahir'] ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Anak Ke</strong></div>
                            <div class="col-md-8">: {{ $data['child']['anak_ke'] ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Alamat</strong></div>
                            <div class="col-md-8">: {{ $data['child']['alamat'] ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Data Timbangan</h4>
                    </div>
                    <div class="container">
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Timbangan</th>
                                        <th>Berat Badan</th>
                                        <th>Tinggi Badan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['histori'] as $tanggal => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tanggal }}</td>
                                            <td>{{ $value['berat_badan'] }} kg</td>
                                            <td>{{ $value['tinggi_badan'] }} cm</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="container">
                        <div class="row">
                            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                            <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                            <script>
                                var chart = new CanvasJS.Chart("chartContainer", {
                                    title: {
                                        text: "Grafik Berat dan Tinggi Badan"
                                    },
                                    axisX: {
                                        valueFormatString: "DD MMM YYYY"
                                    },
                                    axisY: {
                                        title: "Berat Badan (kg)",
                                        includeZero: false
                                    },
                                    axisY2: {
                                        title: "Tinggi Badan (cm)",
                                        includeZero: false
                                    },
                                    data: [{
                                            type: "line",
                                            name: "Berat Badan",
                                            xValueType: "dateTime",
                                            showInLegend: true,
                                            dataPoints: {!! json_encode($data['chartData']['weights'], JSON_NUMERIC_CHECK) !!}
                                        },
                                        {
                                            type: "line",
                                            name: "Tinggi Badan",
                                            xValueType: "dateTime",
                                            axisYType: "secondary",
                                            showInLegend: true,
                                            dataPoints: {!! json_encode($data['chartData']['heights'], JSON_NUMERIC_CHECK) !!}
                                        }
                                    ]
                                });
                                chart.render();
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
