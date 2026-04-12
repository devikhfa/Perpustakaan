@extends('layoutes.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Pengguna</h1>
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
    <h3 class="card-title">Daftar Pengguna</h3>

    @if(Session::get('user_role') == 1)
        <a href="{{ route('pengguna.create') }}" class="btn btn-sm btn-primary card-tools">
            Tambah data
        </a>
    @endif
</div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Password</th>
            <th>Alamat</th>
                <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($pengguna as $k)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $k->nama_pengguna }}</td>
                <td>{{ $k->email }}</td>
                <td>{{ $k->password }}</td>
                <td>{{ $k->alamat }}</td>
                <td>
                    <a href="{{ route('pengguna.detail', $k->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> Detail
                    </a>

                    @if(Session::get('user_role') == 1)
                        <a href="{{ route('pengguna.edit', $k->id) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    @endif

                    @if(in_array(Session::get('user_role'), [1, 2]))
                        <form action="{{ route('pengguna.destroy', $k->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin mau hapus?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    @endif
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

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection
