<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    @include('layouts.head')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('layouts.sidebar')

            <div class="layout-page">

                @include('layouts.navbar')

                {{-- //content --}}
                <div class="content-wrapper">
                    <link rel="stylesheet" href="{{ asset('template/assets/css/datatable.css') }}" />

                    <script src="{{ asset('template/assets/js/datatable-jquery.js') }}"></script>
                    <script src="{{ asset('template/assets/js/datatable-bootstrap5.js') }}"></script>
                    <script src="{{ asset('template/assets/js/datatable-button-html5.js') }}"></script>
                    <script src="{{ asset('template/assets/js/datatable-button.js') }}"></script>
                    <script src="{{ asset('template/assets/js/datatable-button5.js') }}"></script>
                    <script src="{{ asset('template/assets/js/datatable-chekbox.js') }}"></script>
                    <script src="{{ asset('template/assets/js/datatable-print.js') }}"></script>
                    <script src="{{ asset('template/assets/js/datatable-responsive.js') }}"></script>
                    <script src="{{ asset('template/assets/js/datatable-responsiveb5.js') }}"></script>

                    @yield('content')

                    <footer class="content-footer footer bg-footer-theme">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                Sistem Pelayanan Posyandu
                            </div>

                        </div>
                    </footer>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

</body>

</html>
