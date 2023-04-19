<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @stack('metas')
    <title>{{env('APP_NAME')}} | {{ $page_title }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!-- Tempusdominus Bootstrap 4 -->
    <link href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    <!-- Theme style -->
    <link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet">
    <!-- overlayScrollbars -->
    <link href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <!-- Daterange picker -->
    <link href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css" rel="stylesheet">
    @yield('style')
    @yield('styles')
</head>
@php
    $role = "employee";
    if(Auth::guard('employee')->user()->supervised_employee()->count() > 0){
        $role = "supervisor";
    }
@endphp
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a class="brand-link" href="/">
                {{-- <img class="brand-image img-circle elevation-3" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" style="opacity: .8"> --}}
                <span class="brand-text font-weight-light ml-3">{{env('APP_NAME')}}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    {{-- <div class="image">
                        <img class="img-circle elevation-2" src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="User Image">
                    </div> --}}
                    <div class="info">
                        <a class="d-block" href="#">{{$role}} - {{Auth::guard('employee')->user()->name}}</a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false" role="menu">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item  @if (Request::path() == '/dashboard') menu-open @endif">
                            <a class="nav-link" href="/dashboard">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">Manage</li>
                        @if($role == "employee")
                        <li class="nav-item @if (Request::is('manage/daily-schedule/*') || Request::is('manage/daily-schedule')) menu-open @endif">
                            <a class="nav-link " href="/manage/daily-schedule">
                                <i class="nav-icon fas fa-calendar"></i>
                                <p>
                                    Daily Schedules
                                </p>
                            </a>
                        </li>
                        @endif
                        @if($role == "supervisor")
                        <li class="nav-item @if (Request::is('manage/products/*') || Request::is('manage/products')) menu-open @endif">
                            <a class="nav-link " href="/manage/products">
                                <i class="nav-icon ion ion-person"></i>
                                <p>
                                    Supervised Employee
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">Review</li>
                        <li class="nav-item @if (Request::is('manage/message/*') || Request::is('manage/message')) menu-open @endif">
                            <a class="nav-link" href="/manage/message">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Supervised FWA Request
                                </p>
                            </a>
                        </li>
                        <li class="nav-item @if (Request::is('manage/message/*') || Request::is('manage/message')) menu-open @endif">
                            <a class="nav-link" href="/manage/message">
                                <i class="nav-icon fas fa-inbox"></i>
                                <p>
                                    Supervised Schedules
                                </p>
                            </a>
                        </li>
                        @endif
                        <li class="nav-header">Account</li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('content')

        @stack('modals')
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2023 <a href="https://cheese-works.com">Cheese Works</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('dist/js/demo.js') }}"></script> --}}
    <!-- SweetAlert2 -->
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 422) {
                    let errors = jqXHR.responseJSON.errors;
                    let errors_html = laravelValidationToHtmlList(errors);
                    showToast('warning', "", errors_html)
                } else if (jqXHR.status == 429) {
                    showToast('danger', "", getMetaContent('lang-too_many_request_message'))
                }
            }
        });

        function laravelValidationToHtmlList(errors) {
            let errors_html = '<ul style="margin-left:-16px;">';
            for (let key in errors) {
                let text = "";
                for (let msg of errors[key]) {
                    text += msg + "\n";
                }
                // $('[name="' + key + '"]').addClass('is-invalid');
                // $('#' + key + '_error').text(text);
                errors_html += "<li>" + text + "</li>"
            }
            errors_html += "</ul>";
            return errors_html;
        }

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        function showToast(type, title, message) {
            Toast.fire({
                icon: type,
                title: message
            });
        }
    </script>
    @yield('script')
    @stack('scripts')
</body>

</html>
