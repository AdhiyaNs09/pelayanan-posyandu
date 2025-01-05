<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('template') }}" data-template="vertical-menu-template-free">

<head>
    @include('layouts.head')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('layouts.sidebar')

            <div class="layout-page">

                @include('layouts.navbar')
                <div class="container mt-3">
                    @if (session('error'))
                        <div id="flash-message-error" class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div id="flash-message-success" class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

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
    <script>
        // Fungsi untuk menyembunyikan pesan flash setelah 5 detik
        setTimeout(function() {
            let errorMessage = document.getElementById('flash-message-error');
            let successMessage = document.getElementById('flash-message-success');

            if (errorMessage) {
                errorMessage.style.display = 'none';
            }

            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000); // 5000 ms = 5 detik
    </script>


</body>

</html>
