<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title> @yield('title')</title>

    <script>
        var base_url = '{{ config('app.url') }}';
    </script>
    <!-- Google Font: Source Sans Pro -->
    <!-- jQuery -->
    <script src="{{ asset('/admin-assets/plugins/jquery/jquery.min.js') }}"></script>
    {{-- --toster links--- --}}
    <script src="//cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>
    <!-- Toastr JS -->
    <script src="{{ url('/admin-assets/plugins/toastr/toastr.min.js') }}"></script>

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    {{-- --toster links end here--- --}}

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('/admin-assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/admin-assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/admin-assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/admin-assets/dist/css/adminlte.min.css') }}">
    <!-- TOASTR -->
    <link rel="stylesheet" href="{{ asset('/admin-assets/plugins/toastr/toastr.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('/admin-assets/plugins/summernote/summernote-bs4.min.css') }}">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-----Custom Style Sheet------->
    <link rel="stylesheet" href="{{ asset('/admin-assets/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin-assets/assets/css/admin.css') }}">
    <!-- selectTo cdn -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- --sweet alert min.css--- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.min.css"
        integrity="sha512-WxRv0maH8aN6vNOcgNFlimjOhKp+CUqqNougXbz0E+D24gP5i+7W/gcc5tenxVmr28rH85XHF5eXehpV2TQhRg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!--------------Navbar header part start ----------------------->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        @if (!empty(Auth::guard('admin')->user()->profile_image))
                            <img src="{{ url('/admin-assets/uploads/profileimages') }}/{{ auth()->guard('admin')->user()->profile_image }}"
                                class="user-image img-circle elevation-2" alt="User Image">
                        @else
                            <img src="{{ url('/admin-assets/uploads/placeholderImage/admin.jpg') }}"
                                class="user-image img-circle elevation-2" alt="User Image">
                        @endif

                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            @if (!empty(Auth::guard('admin')->user()->profile_image))
                                <img src="{{ url('/admin-assets/uploads/profileimages') }}/{{ auth()->guard('admin')->user()->profile_image }}"
                                    class="user-image img-circle elevation-2" alt="User Image">
                            @else
                                <img src="{{ url('/admin-assets/uploads/placeholderImage/admin.jpg') }}"
                                    class="user-image img-circle elevation-2" alt="User Image">
                            @endif
                            <p> {{ !empty(auth()->guard('admin')->user()) ? auth()->guard('admin')->user()->name : 'N/A'
                                }}
                            </p>
                        </li>
                </li>
                <li class="user-footer">
                    <a href="{{ route('profile') }}" class="btn btn-default btn-flat">Profile</a>
                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right">Sign out</a>
                </li>
            </ul>
            </ul>
        </nav>
        <!---------------------Navbar header part end here--------------->

        <!------------------------- Main Sidebar Container----------------------------->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (!empty(Auth::guard('admin')->user()->profile_image))
                            <img src="{{ url('/admin-assets/uploads/profileimages') }}/{{ auth()->guard('admin')->user()->profile_image }}"
                                class="img-circle elevation-2" alt="User Image"
                                style="height: 2.1rem; width: 2.1rem; object-fit: cover;">
                        @else
                            <img src="{{ url('/admin-assets/uploads/placeholderImage/admin.jpg') }}"
                                class="img-circle elevation-2" alt="User Image"
                                style="height: 2.1rem; width: 2.1rem; object-fit: cover;">
                        @endif
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ !empty(auth()->guard('admin')->user()) ?
    auth()->guard('admin')->user()->name : 'N/A' }}</a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column sidebar-dark-primary" data-widget="treeview"
                        role="menu" data-accordion="false">
                        <li class="nav-item ">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!----All-Users----->
                        <li class="nav-item">
                            <a href="{{ route('user.list') }}"
                                class="nav-link {{ Route::currentRouteName() == 'user.list' ? 'active' : '' }}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <!----Pages----->
                        <li class="nav-item">
                            <a href="{{ route('pages') }}"
                                class="nav-link {{ Request::is('admin/pages*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Pages</p>
                            </a>
                        </li>


                        <!----Animal Videos----->
                        <li class="nav-item">
                            <a href="{{route('animal.videos')}}"
                                class="nav-link {{Route::is('animal.videos') ? 'active' : ''}}">
                                <i class="nav-icon fa-solid fas fa-video"></i>
                                <p>
                                    Videos
                                </p>

                            </a>
                        </li>

                        <!----Scene Audio----->
                        <li class="nav-item">
                            <a href="{{route('scene.index')}}"
                                class="nav-link {{Route::is('scene.index') ? 'active' : ''}}">
                                <i class='nav-icon fas fa-audio-description'></i>
                                <p>
                                    Scene Audio
                                </p>

                            </a>
                        </li>

                        <!----Language----->
                        <li class="nav-item">
                            <a href="{{route('language.index')}}"
                                class="nav-link {{ Request::routeIs('language.index') ? 'active' : '' }}">
                                <i class='nav-icon fas fa-language'></i>
                                <p>
                                    Language
                                </p>
                            </a>
                        </li>

                        {{----------report user and post code end here------}}
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield ("content")
        </div>
        <!-- /.content-wrapper -->

        <!------------------- Main Footer---------------- -->
        {{-- <footer class="main-footer">
        </footer> --}}
        <!------------------- Main Footer end here----------->
    </div>

    {{-- ----toster------- --}}
    @if (Session::has('success'))
    <script>
        $(document).ready(function () {
            toastr.success("{{ session('success') }}", "Success", {
                closeButton: true,
                progressBar: true
            });
        });
    </script>
    @endif

    @if (Session::has('error'))
    <script>
        $(document).ready(function () {
            toastr.error("{{ session('error') }}", "Error", {
                closeButton: true,
                progressBar: true
            });
        });
    </script>
    @endif

    <!-- REQUIRED SCRIPTS -->

    <!-- Bootstrap -->
    <script src="{{ asset('/admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- overlayScrollbars -->
    <script src="{{ asset('/admin-assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/admin-assets/dist/js/adminlte.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('/admin-assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('/admin-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('/admin-assets/plugins/chart.js/Chart.min.js') }}"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('/admin-assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/admin-assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/admin-assets/assets/js/admin.js') }}"></script>
    {{-- -------------------------------- --}}
    <!-- selectTo cdn -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SweetAlert2 -->
    {{-- <!-- <script src="{{ asset('/admin-assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script> --> --}}
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script> -->
    <!-- SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.min.js"
        integrity="sha512-w4LAuDSf1hC+8OvGX+CKTcXpW4rQdfmdD8prHuprvKv3MPhXH9LonXX9N2y1WEl2u3ZuUSumlNYHOlxkS/XEHA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>