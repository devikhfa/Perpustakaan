@extends('layoutes.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Edit Buku</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Edit Buku</li>
        </ol>
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
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Buku</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="judul" class="form-control" id="judul" placeholder="Masukan Judul" value="{{ old('judul', $buku->judul) }}">
                            @error('judul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" 
                                        {{ old('kategori_id', $buku->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Penulis</label>
                            <input type="text" name="penulis" class="form-control" id="penulis" placeholder="Masukan Penulis" value="{{ old('penulis', $buku->penulis) }}">
                            @error('penulis')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" id="penerbit" placeholder="Masukan Penerbit" value="{{ old('penerbit', $buku->penerbit) }}">
                            @error('penerbit')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" class="form-control" id="tahun_terbit" placeholder="Masukan Tahun Terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                            @error('tahun_terbit')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Sampul</label>
                            <input type="file" name="sampul" class="form-control" id="sampul">
                            @error('sampul')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="number" name="qty" class="form-control" id="qty" placeholder="Masukan Qty" value="{{ old('qty', $buku->qty) }}">
                            @error('qty')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Submit</button>
                        <a href="{{ route('buku.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
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
