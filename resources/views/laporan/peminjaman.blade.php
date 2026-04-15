@extends('layoutes.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Laporan Peminjaman</h1>
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
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalBuku ?? 0 }}</h3>
                        <p>Total Buku</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('buku.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalPetugas ?? 0 }}</h3>
                        <p>Total Petugas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('pengguna.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalPinjaman ?? 0 }}</h3>
                        <p>Total Pinjaman Aktif</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fas fa"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</h3>
                        <p>Total Denda</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer"> <i class="fas fa"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Peminjaman Buku</h3>
                    </div>
                    <div class="card-body pb-0">
                        <form method="GET" action="{{ route('laporan.peminjaman') }}">
                            <div class="row align-items-end">

                                <div class="col-md-3">
                                    <label class="font-weight-bold">Dari Tanggal</label>
                                    <input type="date" name="dari" class="form-control"
                                        value="{{ request('dari') }}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold">Sampai Tanggal</label>
                                    <input type="date" name="sampai" class="form-control"
                                        value="{{ request('sampai') }}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold">Berdasarkan</label>
                                    <select name="filter" class="form-control">
                                        <option value="tgl_pinjam" {{ request('filter') == 'tgl_pinjam' ? 'selected' : '' }}>
                                            Tanggal Pinjam
                                        </option>
                                        <option value="tgl_dikembalikan" {{ request('filter') == 'tgl_dikembalikan' ? 'selected' : '' }}>
                                            Tanggal Kembali
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-primary mr-2">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="{{ route('laporan.peminjaman') }}" class="btn btn-secondary">
                                            <i class="fas fa-sync"></i> Reset
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anggota</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>                          
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Keterlambatan</th>
                                    <th>Total Denda</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $key => $t)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $t->nama_pengguna }}</td>
                                    <td>{{ $t->judul }}</td>
                                    <td>
                                        @if($t->tgl_pinjam)
                                            {{ \Carbon\Carbon::parse($t->tgl_pinjam)->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($t->tgl_jatuh_tempo)
                                            {{ \Carbon\Carbon::parse($t->tgl_jatuh_tempo)->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($t->tgl_dikembalikan)
                                            {{ \Carbon\Carbon::parse($t->tgl_dikembalikan)->format('d/m/Y') }}
                                        @else
                                            <span class="badge badge-warning">Belum Kembali</span>
                                        @endif
                                    </td>
                                    <!-- hitung keterlambatan -->
                                    <td>
                                        @php
                                            $hariTerlambat = 0;
                                            $tglKembali = $t->tgl_dikembalikan ?? now();
                                            if ($tglKembali > $t->tgl_jatuh_tempo) {
                                                $hariTerlambat = abs(($tglKembali->startOfDay())->diffInDays($t->tgl_jatuh_tempo->startOfDay()));
                                            }
                                        @endphp
                                        @if($hariTerlambat > 0)
                                            <span class="text-danger">{{ $hariTerlambat }} hari</span>
                                        @else
                                            <span class="text-success">-</span>
                                        @endif
                                    </td>
                                    <!-- hitung denda -->
                                    <td>
                                        <span class="text-danger font-weight-bold">
                                            Rp {{ number_format($t->denda, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <!-- status transaksi -->
                                    <td>
                                        @if($t->status_transaksi == 1)
                                            <span class="badge badge-primary">Menunggu Konfirmasi Peminjaman</span>
                                        @elseif($t->status_transaksi == 2)
                                            <span class="badge badge-info">Dipinjam</span>
                                        @elseif($t->status_transaksi == 3)
                                            <span class="badge badge-warning">Menuggu Konfirmasi Pengembalian</span>
                                        @else
                                            <span class="badge badge-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle"></i> Belum ada data peminjaman
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
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
