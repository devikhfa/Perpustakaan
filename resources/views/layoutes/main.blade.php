<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons (Ini dari URL luar/CDN, tidak perlu asset()) -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
</head>
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
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Perpustakaan</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(Session::has('user_id') && $user = \App\Models\Pengguna::find(Session::get('user_id')))
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" class="img-circle elevation-2" style="width:45px;height:45px;object-fit:cover;" alt="User Image">
                    @else
                        <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" style="width:45px;height:45px;object-fit:cover;" alt="User Image">
                    @endif
                @endif
            </div>
            <div class="info">
                <a href="{{ route('pengguna.profile') }}" class="d-block">
                    {{ $user->nama_pengguna }}
                </a>
                <small>
                    @php
                        $role = Session::get('user_role');
                        switch($role) {
                            case 1:
                                $roleText = 'Kepala Perpustakaan';
                                $badgeColor = 'danger';
                                break;
                            case 2:
                                $roleText = 'Petugas';
                                $badgeColor = 'warning';
                                break;
                            case 3:
                                $roleText = 'Anggota';
                                $badgeColor = 'success';
                                break;
                            default:
                                $roleText = 'Unknown';
                                $badgeColor = 'secondary';
                        }
                    @endphp
                    <span class="badge badge-{{ $badgeColor }}">{{ $roleText }}</span>
                </small>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                @php
                    $role = Session::get('user_role');
                @endphp

                <li class="nav-header">Dashboard</li>
                
                <!-- Katalog (Semua role bisa akses) -->
                <li class="nav-item">
                    <a href="{{ route('katalog.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Katalog</p>
                    </a>
                </li>

                <!-- Menu untuk Role Kepala Perpustakaan (Role 1) -->
                @if($role == 1)
                    <li class="nav-header">Laporan</li>
                    <li class="nav-item">
                        <a href="{{ route('laporan.peminjaman')}}" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>Laporan Peminjaman</p>
                        </a>
                    </li>
                @endif

                <!-- Menu untuk Role Petugas (Role 2) -->
                @if($role == 2)
                    <li class="nav-header">Transaksi</li>
                    <li class="nav-item">
                        <a href="{{ route('transaksi.datapeminjaman')}}" class="nav-link">
                            <i class="nav-icon fas fa-book-open"></i>
                            <p>Data Peminjaman</p>
                        </a>
                    </li>

                    <li class="nav-header">Master</li>
                    <li class="nav-item">
                        <a href="{{ route('buku.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Buku</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kategori.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="{{ route('pengguna.index') }}" class="nav-link">
                            <i class="nav-icon far fa-user"></i>
                            <p>Pengguna</p>
                        </a>
                    </li> -->
                @endif

                <!-- Menu untuk Role Anggota (Role 3) -->
                @if($role == 3)
                    <li class="nav-header">Riwayat</li>
                    <li class="nav-item">
                        <a href="{{ route('transaksi.riwayatpeminjaman')}}" class="nav-link">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Riwayat Peminjaman</p>
                        </a>
                    </li>
                @endif

                <!-- Menu untuk Role Kepala Perpustakaan & Petugas bisa akses Pengguna -->
                @if($role == 1 || $role == 2)
                    <!-- Menu Pengguna untuk Kepala dan Petugas -->
                    <li class="nav-header">Manajemen</li>
                    <li class="nav-item">
                        <a href="{{ route('pengguna.index') }}" class="nav-link">
                            <i class="nav-icon far fa-user"></i>
                            <p>Pengguna</p>
                        </a>
                    </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2026-2027 Ikhfa Risyah Aprilia</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
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
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- DataTables & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
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
<!-- AdminLTE dashboard demo -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
</body>
</html>