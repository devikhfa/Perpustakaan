@extends('layoutes.main')

@section('content')

<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Buku</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('buku.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Detail Buku</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

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

                        <!-- cek apakah sampul kosong -->
                        @if(empty($buku->sampul))
                            <!-- default image -->
                            <img src="{{ url('image/nophoto.jpg') }}"
                                class="img-fluid rounded"
                                style="max-height: 300px;">
                        @else
                             <!-- gambar dari database -->
                            <img src="{{ url('image/'.$buku->sampul) }}"
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
                                <td>: {{ $buku->judul }}</td>
                            </tr>

                            <tr>
                                <th>Kategori</th>
                                <td>: {{ $buku->kategori }}</td>
                            </tr>

                            <tr>
                                <th>Penulis</th>
                                <td>: {{ $buku->penulis }}</td>
                            </tr>

                            <tr>
                                <th>Penerbit</th>
                                <td>: {{ $buku->penerbit }}</td>
                            </tr>

                            <tr>
                                <th>Tahun Terbit</th>
                                <td>: {{ $buku->tahun_terbit }}</td>
                            </tr>

                            <tr>
                                <th>Qty</th>
                                <td>: {{ $buku->qty }}</td>
                            </tr>

                        </table>

                        <a href="{{ route('buku.index') }}" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>

                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-success float-right" style="margin-right: 5px;">
                            <i class="fas fa-edit"></i> Edit</a>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection