@extends('layoutes.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Detail Buku</h1>
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
                        <h3 class="card-title">Sampul Buku</h3>
                    </div>

                    <div class="card-body text-center">

                        @if(empty($buku[0]->sampul))
                            <img src="{{ url('image/nophoto.jpg') }}"
                                class="img-fluid rounded"
                                style="max-height: 300px;">
                        @else
                            <img src="{{ url('image/'.$buku[0]->sampul) }}"
                                class="img-fluid rounded"
                                style="max-height: 300px;">
                        @endif

                    </div>
                </div>
            </div>

            <!-- Card Detail -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Buku</h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-borderless">

                            <tr>
                                <th width="200">Judul</th>
                                <td>: {{ $buku[0]->judul }}</td>
                            </tr>

                            <tr>
                                <th>Kategori</th>
                                <td>: {{ $buku[0]->kategori }}</td>
                            </tr>

                            <tr>
                                <th>Penulis</th>
                                <td>: {{ $buku[0]->penulis }}</td>
                            </tr>

                            <tr>
                                <th>Penerbit</th>
                                <td>: {{ $buku[0]->penerbit }}</td>
                            </tr>

                            <tr>
                                <th>Tahun Terbit</th>
                                <td>: {{ $buku[0]->tahun_terbit }}</td>
                            </tr>

                            <tr>
                                <th>Qty</th>
                                <td>: {{ $buku[0]->qty }}</td>
                            </tr>

                        </table>

                        <a href="{{ route('buku.index') }}" class="btn btn-secondary btn-sm">
                            Kembali
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
