@extends('layoutes.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Detail Pengguna</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <!-- Card Sampul -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Foto Profile</h3>
                    </div>

                    <div class="card-body text-center">
                        @if($pengguna->foto)
                            <img src="{{ asset('storage/' . $pengguna->foto) }}" class="img-fluid rounded" style="max-height: 300px;">
                        @else
                            <img src="{{ url('image/nophoto.jpg') }}" class="img-fluid rounded" style="max-height: 300px;">
                        @endif

                    </div>
                </div>
            </div>

            <!-- Card Detail -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Pengguna</h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-borderless">

                            <tr>
                                <th width="200">Nama</th>
                                <td>: {{ $pengguna->nama_pengguna }}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>: {{ $pengguna->email }}</td>
                            </tr>

                            <tr>
                                <th>Password</th>
                                <td>: {{ $pengguna->password }}</td>
                            </tr>

                            <tr>
                                <th>Alamat</th>
                                <td>: {{ $pengguna->alamat }}</td>
                            </tr>

                        </table>

                        <a href="{{ route('pengguna.index') }}" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
<!-- /.content -->

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection
