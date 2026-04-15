@extends('layoutes.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Detail Transaksi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Detail Transaksi</li>
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
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Peminjam <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_peminjam" class="form-control" id="nama_peminjam" value="{{ $transaksi->nama_pengguna}}" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Email Peminjam</label>
                                    <input type="text" name="email_peminjam" class="form-control" id="email_peminjam" value="{{ $transaksi->email}}" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Alamat Peminjam</label>
                                    <input type="text" name="alamat_peminjam" class="form-control" id="alamat_peminjam" value="{{ $transaksi->alamat}}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Tanggal Pinjam <span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_pinjam" class="form-control" id="tgl_pinjam" value="{{ $transaksi->tgl_pinjam ? $transaksi->tgl_pinjam->format('Y-m-d') : '' }}" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_jatuh_tempo" class="form-control" id="tgl_jatuh_tempo" value="{{ $transaksi->tgl_jatuh_tempo ? $transaksi->tgl_jatuh_tempo->format('Y-m-d') : '' }}" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Tanggal Dikembalikan</label>
                                    <input type="date" name="tgl_dikembalikan" class="form-control" id="tgl_dikembalikan" value="{{ $transaksi->tgl_dikembalikan ? $transaksi->tgl_dikembalikan->format('Y-m-d') : '' }}" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Denda</label>
                                    <input type="text" name="denda" class="form-control" id="denda" value="{{ number_format($transaksi->denda, 0, ',', '.') }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <label>Detail Buku Yang Dipinjam</label>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Kategori</th>
                                            <th>Penulis</th>
                                            <th>Penerbit</th>
                                            <th>Tahun Terbit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $transaksi->judul }}</td>
                                            <td>{{ $transaksi->nama_kategori }}</td>
                                            <td>{{ $transaksi->penulis }}</td>
                                            <td>{{ $transaksi->penerbit }}</td>
                                            <td>{{ $transaksi->tahun_terbit }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="3" placeholder="Isi catatan jika diperlukan..." disabled>{{ $transaksi->catatan }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Button row -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="{{ route('katalog.index') }}" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.invoice -->
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
