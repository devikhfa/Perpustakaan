@extends('layoutes.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Pinjam Buku</h1>
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
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <form action="{{ route('katalog.store') }}" method="POST" id="formTransaksi">
                        @csrf
                        
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Peminjam <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_peminjam" class="form-control" id="nama_peminjam" value="{{ Session::get('user_nama', 'Pengguna') }}" readonly>
                                    <input type="hidden" name="peminjam_id" id="peminjam_id" value="{{ Session::get('user_id') }}">
                                    <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                    @error('peminjam_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Email Peminjam</label>
                                    <input type="text" name="email_peminjam" class="form-control" id="email_peminjam" value="{{ Session::get('user_email', '-') }}" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Alamat Peminjam</label>
                                    <input type="text" name="alamat_peminjam" class="form-control" id="alamat_peminjam" value="{{ Session::get('user_alamat', '-') }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tanggal Pinjam <span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_pinjam" class="form-control" id="tgl_pinjam" value="{{ old('tgl_pinjam', date('Y-m-d')) }}" required>
                                    @error('tgl_pinjam')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_jatuh_tempo" class="form-control" id="tgl_jatuh_tempo" value="{{ old('tgl_jatuh_tempo') }}" readonly required>
                                    <small class="form-text text-muted">Otomatis 3 hari kerja (tidak termasuk Sabtu & Minggu)</small>
                                    @error('tgl_jatuh_tempo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                                            <th>Stok Tersedia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $buku->judul }}</td>
                                            <td>{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                                            <td>{{ $buku->penulis }}</td>
                                            <td>{{ $buku->penerbit }}</td>
                                            <td>{{ $buku->tahun_terbit }}</td>
                                            <td class="text-{{ $buku->qty > 0 ? 'success' : 'danger' }}">
                                                {{ $buku->qty }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="3" placeholder="Isi catatan jika diperlukan...">{{ old('catatan') }}</textarea>
                                    @error('catatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Button row -->
                        <div class="row no-print">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success float-right" {{ $buku->qty <= 0 ? 'disabled' : '' }}>
                                <a href="{{route('transaksi.riwayatpeminjaman')}}"></a>
                                    <i class="fas fa-save"></i> Submit
                                </button>
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
<script>
    function hitungTanggalJatuhTempo(tanggalPinjam) {
        if (!tanggalPinjam) return '';
        
        let tanggal = new Date(tanggalPinjam);
        let hariKerja = 0;
        
        while (hariKerja < 3) {
            tanggal.setDate(tanggal.getDate() + 1);
            if (tanggal.getDay() !== 0 && tanggal.getDay() !== 6) {
                hariKerja++;
            }
        }
        const tahun = tanggal.getFullYear();
        const bulan = String(tanggal.getMonth() + 1).padStart(2, '0');
        const hari = String(tanggal.getDate()).padStart(2, '0');
        
        return `${tahun}-${bulan}-${hari}`;
    }
    
    document.getElementById('tgl_pinjam').addEventListener('change', function() {
        const tglJatuhTempo = hitungTanggalJatuhTempo(this.value);
        document.getElementById('tgl_jatuh_tempo').value = tglJatuhTempo;
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const tglPinjam = document.getElementById('tgl_pinjam');
        if (tglPinjam.value) {
            const tglJatuhTempo = hitungTanggalJatuhTempo(tglPinjam.value);
            document.getElementById('tgl_jatuh_tempo').value = tglJatuhTempo;
        }
        
        document.getElementById('formTransaksi').addEventListener('submit', function(e) {
            const stokTersedia = {{ $buku->qty }};
            if (stokTersedia <= 0) {
                e.preventDefault();
                alert('Maaf, stok buku sedang kosong!');
                return false;
            }
        });
    });
</script>
@endsection
