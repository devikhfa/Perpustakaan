@extends('layoutes.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Buku</h1>
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
                <h3 class="card-title">Daftar Buku</h3>
                <a href="{{ route('buku.create') }}" class="btn btn-sm btn-primary card-tools">Tambah data</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Sampul</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $buku as $k )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->judul }}</td>
                                <td>{{ $k->kategori }}</td>
                                <td>{{ $k->penulis }}</td>
                                <td>{{ $k->penerbit }}</td>
                                <td>{{ $k->tahun_terbit }}</td>
                                <td>
                                    @empty($k->sampul)
                                    <img src="{{url('image/nophoto.jpg')}}"
                                        alt="project-image" class="rounded" style="width: 100%; max-width: 100px; height: auto;">
                                    @else
                                    <img src="{{url('image')}}/{{$k->sampul}}" alt="project-image" class="rounded" style="width: 100px; height: 150px; object-fit: cover;">
                                    @endempty
                                </td>
                                <td>{{ $k->qty }}</td>
                                <td>
                                    <a href="{{ route('buku.show', $k->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Detail</a>
                                    <a href="{{ route('buku.edit', $k->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('buku.destroy', $k->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
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
@endsection
