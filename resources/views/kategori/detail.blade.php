@extends('layoutes.main')

@section('content')

<!-- ===== HEADER ===== -->
<div class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-6">
                <h1 class="m-0">Detail Kategori</h1>
            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>

        </div>

    </div>
</div>

<!-- ===== CONTENT ===== -->
<section class="content">
<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <!-- CARD DETAIL -->
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Informasi Kategori</h3>
                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>
                            <th width="150">ID</th>
                            <td>: {{ $kategori->id }}</td>
                        </tr>

                        <tr>
                            <th>Kategori</th>
                            <td>: {{ $kategori->nama_kategori }}</td>
                        </tr>

                        <tr>
                            <th>Deskripsi</th>
                            <td>: {{ $kategori->deskripsi ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>:
                                @if($kategori->status)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Dibuat</th>
                            <td>: {{ $kategori->created_at }}</td>
                        </tr>

                        <tr>
                            <th>Update</th>
                            <td>: {{ $kategori->updated_at }}</td>
                        </tr>

                    </table>

                </div>

                <div class="card-footer text-right">

                    <a href="{{ route('kategori.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>

                </div>

            </div>

        </div>

    </div>

</div>
</section>

@endsection