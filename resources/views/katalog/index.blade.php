@extends('layoutes.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Katalog Buku</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Katalog Buku</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12">
        <form action="{{ route('katalog.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari judul atau kategori buku..."
                    value="{{ request('search') }}">

                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Buku</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            @foreach ( $buku as $k )
                                <div class="col-md-2">
                                    <div class="card shadow-lg">
                                        <img 
                                            src="{{url('image')}}/{{$k->sampul}}"
                                            class="card-img-top w-100"
                                            style="
                                                height: 400px; 
                                                object-fit: cover;
                                            "
                                        >
                                        <div class="card-body">
                                            <h5 class="font-weight-bold text-primary">
                                                {{ $k->judul }}
                                            </h5>
                                            <h6 class="text-muted d-block">
                                                Kategori: {{ $k->kategori }}
                                            </h6>
                                            <h6 class="text-muted d-block mb-2">
                                                Status: <span class="badge bg-success">Tersedia</span>
                                            </h6>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('katalog.detail', $k->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                @php
                                                    $role = Session::get('user_role');
                                                @endphp
                                                 <!-- hanya user role 3 yang bisa pinjam -->
                                                @if($role == 3)
                                                    <a href="{{ route('katalog.pinjam', $k->id) }}" class="btn btn-sm btn-success">
                                                        <i class="fas fa-book"></i> Pinjam
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.card-body -->
        </div>
        </div>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
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
