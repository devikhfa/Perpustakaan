@extends('layoutes.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Data Peminjaman</h1>
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
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Peminjaman</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Tanggal Kembali</th>
                            <th>Denda</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $key => $t)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $t->peminjam->nama_pengguna ?? $t->peminjam_id }}</td>
                            <td>{{ $t->buku->judul ?? 'Buku tidak ditemukan' }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->tgl_pinjam)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->tgl_jatuh_tempo)->format('d/m/Y') }}</td>
                            <td>
                                @if($t->tgl_dikembalikan)
                                    {{ \Carbon\Carbon::parse($t->tgl_dikembalikan)->format('d/m/Y') }}
                                @else
                                    <span class="badge badge-warning">Belum dikembalikan</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $denda = 0;
                                    if (!$t->tgl_dikembalikan && now() > $t->tgl_jatuh_tempo) {
                                        $hariTerlambat = now()->diffInDays($t->tgl_jatuh_tempo);
                                        $denda = $hariTerlambat * 2000; // Rp 2000 per hari
                                    } elseif ($t->tgl_dikembalikan && $t->tgl_dikembalikan > $t->tgl_jatuh_tempo) {
                                        $hariTerlambat = \Carbon\Carbon::parse($t->tgl_dikembalikan)->diffInDays($t->tgl_jatuh_tempo);
                                        $denda = $hariTerlambat * 2000;
                                    }
                                @endphp
                                {{ number_format($denda, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($t->status_transaksi == 1)
                                    <span class="badge badge-success">Dipinjam</span>
                                @elseif($t->status_transaksi == 2)
                                    <span class="badge badge-warning">Mengajukan Pengembalian</span>
                                @else
                                    <span class="badge badge-secondary">Dikembalikan</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('transaksi.detailtransaksi', $t->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    @if($t->status_transaksi == 2)
                                    <button type="button" class="btn btn-sm btn-warning">
                                        <i class="fas fa-undo"></i> Konfirmasi Pengembalian
                                    </button>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle"></i> Belum ada data transaksi
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
