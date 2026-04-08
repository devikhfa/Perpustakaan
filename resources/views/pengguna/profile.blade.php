@extends('layoutes.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Profile</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<style>
    body {
        background: #f1f5f9;
    }

    /* CONTAINER */
    .profile-container {
        padding: 10px;
    }

    /* HEADER CARD */
    .profile-header {
        background: white;
        border-radius: 16px;
        padding: 20px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    /* LEFT */
    .profile-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    /* NAME */
    .name {
        font-size: 22px;
        font-weight: 600;
    }

    .profile-menu .active {
        background: #1e3a8a;
        color: white;
    }

    /* CARD BAWAH */
    .profile-card {
        margin-top: 25px;
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    /* TITLE */
    .section-title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    /* ROW */
    .profile-row {
        display: flex;
        margin-bottom: 15px;
    }

    /* LABEL */
    .profile-label {
        width: 150px;
        color: #374151;
    }

    /* VALUE */
    .profile-value {
        color: #64748b;
        cursor: pointer;
    }

    /* INPUT */
    .input {
        border: none;
        border-bottom: 2px solid #1e3a8a;
        outline: none;
        width: 300px;
    }

    /* BUTTON */
    .btn-save {
        margin-top: 20px;
        background: #0f2c59;
        color: white;
        border-radius: 8px;
        padding: 10px 20px;
        border: none;
    }

    /* WRAPPER FOTO */
    .avatar-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* FOTO */
    .avatar-img {
        width: 100px;
        height: 100px;
        border-radius: 90%;
        object-fit: cover;
    }

    /* DEFAULT */
    .default-avatar {
        background: #6366f1;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }

    /* UBAH PROFIL */
    .ubah-foto {
        font-size: 16px;
        color: #2563eb;
        cursor: pointer;
        margin-top: 5px;
    }

</style>

<div class="profile-container">
    <div class="profile-header">
        <div class="profile-left">

            <form action="{{ route('pengguna.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="formFoto">
                @csrf
                @method('PUT')

                <div class="avatar-wrapper">

                    @if($user->foto)
                    <img src="{{ asset('storage/'.$user->foto) }}" class="avatar-img">
                    @else
                    <div class="avatar-img default-avatar">
                        {{ strtoupper(substr($user->nama_pengguna,0,1)) }}
                    </div>
                    @endif

                    <input type="file" name="foto" id="inputFoto" hidden
                        onchange="document.getElementById('formFoto').submit()">

                    <div class="ubah-foto" onclick="document.getElementById('inputFoto').click()">
                        Ubah Profil
                    </div>

                </div>
            </form>

            <div class="profile-info">
                <div class="name">{{ $user->nama_pengguna }}</div>
            </div>

        </div>

    </div>


    <div class="profile-card">

        <div class="section-title">Informasi Profil</div>

        <div class="profile-row">
            <div class="profile-label">Nama</div>

            <div id="text-nama" class="profile-value" onclick="edit('nama')">
                {{ $user->nama_pengguna }}
            </div>

            <input type="text" id="input-nama" class="input d-none"
                value="{{ $user->nama_pengguna }}">
        </div>

        <div class="profile-row">
            <div class="profile-label">Email</div>

            <div id="text-email" class="profile-value" onclick="edit('email')">
                {{ $user->email }}
            </div>

            <input type="text" id="input-email" class="input d-none"
                value="{{ $user->email }}">
        </div>

        <div class="profile-row">
            <div class="profile-label">Alamat</div>

            <div id="text-alamat" class="profile-value" onclick="edit('alamat')">
                {{ $user->alamat ?? '-' }}
            </div>

            <input type="text" id="input-alamat" class="input d-none"
                value="{{ $user->alamat }}">
        </div>

        <div class="profile-row">
            <div class="profile-label">Password</div>

            <div id="text-password" class="profile-value" onclick="edit('password')">
                {{ $user->password ?? '-' }}
            </div>

            <input type="text" id="input-password" class="input d-none"
                value="{{ $user->password }}">
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button class="btn btn-success" onclick="saveProfile()">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>

        </div>
    </div>

</div>

<script>
    function edit(field) {
        document.getElementById('text-' + field).classList.add('d-none');
        document.getElementById('input-' + field).classList.remove('d-none');
        document.getElementById('input-' + field).focus();
    }

    function saveProfile() {
        fetch('{{ route("pengguna.profile.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nama_pengguna: document.getElementById('input-nama').value,
                    email: document.getElementById('input-email').value,
                    alamat: document.getElementById('input-alamat').value
                })
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    location.reload();
                } else {
                    alert(res.message);
                }
            });
    }
</script>

@endsection