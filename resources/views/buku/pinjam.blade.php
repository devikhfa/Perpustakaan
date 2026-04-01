@extends('layoutes.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Pinjam</h1>
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
            <div class="col-12">
                <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Catatan:</h5>
                    Estimasi tanggal pengembalian buku akan terisi secara otomatis, yaitu 3 hari setelah tanggal peminjaman. Jika buku tidak dikembalikan hingga melewati batas waktu tersebut, peminjam akan dikenakan denda.
                </div>
            </div>
        </div>
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Pinjam Buku</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('peminjaman.index')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Peminjam</label>
                            <input type="text" name="" class="form-control" id="" placeholder="Masukan Nama" value="{{ old('') }}">
                        </div>
                        
                        <div class="form-group">
                            <label>Nama buku yang akan di pinjam</label>
                            <input type="text" name="" class="form-control" id="" placeholder="Masukan Buku" value="{{ old('') }}">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tanggal Pinjam</label>
                                    <input type="date" name="tgl_pinjam" class="form-control" id="" placeholder="Masukan Buku" value="{{ old('') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Estimasi Pengembalian</label>
                                    <input type="date" name="estimasi_pengembalian" class="form-control" id="" placeholder="Masukan Buku" value="{{ old('') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
