@extends('layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">SPP 🎉</h5>
                                <p class="mb-2">
                                    Sistem Pelayanan Puskesmas
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{asset('template/img/illustrations/man-with-laptop-light.png')}}"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" height="140">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-3 mb-4">

                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">

                        </div>
                    </div>

                    <h1 class="card-title mb-2"></h1>
                </div>

            </div>
            <div class="col-lg-3 col-md-3 col-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="tf-icons bx bxs-receipt" style="font-size: 3rem; color: #71DD38"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Jumlah Timbangan</span>
                        <h1 class="card-title mb-2"></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="tf-icons bx bxs-receipt" style="font-size: 3rem; color: #71DD38"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Jumlah Anak</span>
                        <h1 class="card-title mb-2"></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
