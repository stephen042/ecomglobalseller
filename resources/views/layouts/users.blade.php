<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{env('APP_NAME')}}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('homeAssets/images/G/01/sell/images/favicon.ico')}}" rel="shortcut icon"
        type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ URL('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ URL('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ URL('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ URL('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ URL('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ URL('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ URL('assets/css/style.css') }}" rel="stylesheet">

    <style>
        * {
            /* font-size: 20px; */
        }

        .table-responsive-x {
            overflow-x: auto;
        }

        .flex-container-user {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .flex-item-user {
            flex: 1;
            /* margin: 5px; */
            padding: 5px;
            text-align: center;
            border: none;
            background-color: #f8f9fa;
        }
    </style>
    @livewireStyles
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="" class="logo d-flex align-items-center" style="height: 200px">
                <span class="d-none d-lg-block">Ecomglobalseller</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
            <li class="nav-item d-flex align-items-center ms-5">
                <img src="{{ URL('assets/img/seller.jpg') }}" alt="seller logo"
                    style="width: 30px; height: 30px ;vertical-align: middle; border-radius: 20%;">
                <span class="fw-bold m-2">GLOBAL DASHBOARD</span>
            </li>

            {{-- @if (Auth::user()->country == "Pakistan" ||
            Auth::user()->country == "United Kingdom" ||
            Auth::user()->country == "United States of America" ||
            Auth::user()->country == "India" ||
            Auth::user()->country == "United Arab Emirates" ||
            Auth::user()->country == "Spain" ||
            Auth::user()->country == "France")
            <!-- Country Flag Section -->
            <li class="nav-item d-flex align-items-center mx-2">
                <a href="#" class="nav-link m-0 p-1">
                    <img src="{{ URL('assets/countriesSvg/' . str_replace(' ', '', Auth::user()->country) . '.svg') }}"
                        alt="Flag" style="width: 34px; height: 34px; vertical-align: middle;">
                </a>
            </li>
            <!-- End Country Flag Section -->
            @endif --}}
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0 text-dark" href="#"
                        data-bs-toggle="dropdown">
                        <span class="m-1"><i class="bi bi-camera"></i></span>
                        <i class="bi bi-chevron-down me-2 fw-bold"></i>
                    </a><!-- End Profile Image Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ auth()->user()->email }}</h6>
                            <span></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <div class="dropdown-item d-flex align-items-center">
                                {{-- sign out --}}
                                <livewire:user.logout />
                            </div>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header>
    <!-- End Header -->


    <!-- ======= Sidebar ======= -->
    <livewire:user.sidebar />
    <!-- End Sidebar-->


    <!-- content goes here -->
    <main id="main" class="main p-2">
        @yield('content')
    </main>
    
    <livewire:user.fund-modal />

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>{{env('APP_NAME')}}</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
        </div>
    </footer>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- live chat -->
    <script id="chatway" async="true" src="https://cdn.chatway.app/widget.js?id=09fTEhjKN73h"></script>

    <!-- Vendor JS Files -->
    <script src="{{ URL('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ URL('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ URL('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ URL('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ URL('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ URL('assets/js/main.js') }}"></script>
    <script>
        function navigateToDashboard(event) {
            event.preventDefault();
            window.location.href = "{{ route('dashboard') }}";
        }
    </script>
    @livewireScripts
</body>

</html>