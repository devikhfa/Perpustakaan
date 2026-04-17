<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register Perpustakaan</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=1200') center/cover no-repeat;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    body::before {
      content: '';
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.55);
    }

    .register-card {
      position: relative;
      z-index: 1;
      width: 620px;
      max-width: 92%;
      background: #fff;
      border-radius: 16px;
      padding: 42px 40px;
      box-shadow: 0 25px 70px rgba(0,0,0,0.35);
    }

    .welcome {
      font-size: 12px;
      font-weight: 700;
      color: #4e8ff8;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 10px;
    }

    h2 {
      font-size: 24px;
      font-weight: 800;
      color: #111827;
      margin-bottom: 6px;
    }

    p {
      font-size: 13px;
      color: #6b7280;
      margin-bottom: 22px;
    }

    .form-group {
      margin-bottom: 14px;
    }

    label {
      font-size: 12px;
      font-weight: 600;
      color: #374151;
      display: block;
      margin-bottom: 6px;
    }

    .input-wrap {
      position: relative;
    }

    .input-wrap i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
    }

    input, textarea {
      width: 100%;
      padding: 11px 12px 11px 38px;
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      background: #fafafa;
      font-size: 13px;
      outline: none;
      font-family: inherit;
    }

    textarea {
      resize: none;
      padding-top: 10px;
    }

    input:focus, textarea:focus {
      border-color: #4e8ff8;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(78,143,248,0.15);
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .btn {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      background: #2f6df6;
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: 700;
      cursor: pointer;
    }

    .btn:hover {
      background: #1a5ce6;
    }

    .footer {
      text-align: center;
      margin-top: 18px;
      font-size: 13px;
      color: #6b7280;
    }

    .footer a {
      color: #2f6df6;
      font-weight: 600;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    .alert {
      padding: 10px 12px;
      border-radius: 10px;
      font-size: 13px;
      margin-bottom: 14px;
    }

    .danger {
      background: #fef2f2;
      color: #b91c1c;
    }

    @media (max-width: 768px) {
      .form-row {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>

<div class="register-card">

  <div class="welcome">Buat Akun Baru</div>
  <h2>Daftar</h2>
  <p>Isi data berikut untuk membuat akun perpustakaan.</p>

  {{-- ✅ ERROR VALIDASI --}}
  @if ($errors->any())
    <div class="alert danger">
      <ul style="padding-left:15px;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- ERROR MANUAL --}}
  @if(session('error'))
    <div class="alert danger">
      {{ session('error') }}
    </div>
  @endif

  <form action="{{ route('register.proses') }}" method="post">
    @csrf

    <div class="form-group">
      <label>Nama Lengkap</label>
      <div class="input-wrap">
        <i class="bi bi-person"></i>
        <input type="text" name="nama_pengguna" value="{{ old('nama_pengguna') }}" required>
      </div>
    </div>

    <div class="form-group">
      <label>Email</label>
      <div class="input-wrap">
        <i class="bi bi-envelope"></i>
        <input type="email" name="email" value="{{ old('email') }}" required>
      </div>
    </div>

    <div class="form-group">
      <label>Alamat</label>
      <div class="input-wrap">
        <i class="bi bi-geo-alt"></i>
        <textarea name="alamat" rows="2">{{ old('alamat') }}</textarea>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>Password</label>
        <div class="input-wrap">
          <i class="bi bi-lock"></i>
          <input type="password" name="password" required>
        </div>
      </div>

      <div class="form-group">
        <label>Konfirmasi</label>
        <div class="input-wrap">
          <i class="bi bi-lock-fill"></i>
          <input type="password" name="password_confirmation" required>
        </div>
      </div>
    </div>

    <button class="btn" type="submit">Daftar</button>
  </form>

  <div class="footer">
    Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
  </div>

</div>

</body>
</html>