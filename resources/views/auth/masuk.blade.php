<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Perpustakaan</title>

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

      /* 🔥 background full gambar (bukan biru lagi) */
      background: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1200') center/cover no-repeat;

      display: flex;
      justify-content: center;
      align-items: center;

      position: relative;
    }

    /* overlay biar lebih gelap & elegan */
    body::before {
      content: '';
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.55);
    }

    /* CARD LOGIN */
    .login-card {
      position: relative;
      z-index: 1;

      width: 520px;
      max-width: 92%;

      background: #fff;
      padding: 50px 42px;
      border-radius: 16px;

      box-shadow: 0 25px 70px rgba(0,0,0,0.3);
    }

    .welcome {
      font-size: 12px;
      font-weight: 700;
      color: #4e8ff8;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 10px;
    }

    h2 {
      font-size: 24px;
      font-weight: 800;
      margin-bottom: 6px;
      color: #111827;
    }

    p {
      font-size: 13px;
      color: #6b7280;
      margin-bottom: 28px;
    }

    .form-group {
      margin-bottom: 16px;
    }

    label {
      font-size: 12px;
      font-weight: 600;
      display: block;
      margin-bottom: 6px;
      color: #374151;
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

    input {
      width: 100%;
      padding: 11px 12px 11px 38px;
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      background: #fafafa;
      outline: none;
      font-size: 13px;
    }

    input:focus {
      border-color: #4e8ff8;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(78,143,248,0.15);
    }

    .remember {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: #6b7280;
      margin: 14px 0 22px;
    }

    button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 10px;
      background: #2f6df6;
      color: white;
      font-weight: 700;
      cursor: pointer;
      transition: 0.2s;
    }

    button:hover {
      background: #1a5ce6;
    }

    .footer {
      text-align: center;
      margin-top: 20px;
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
      margin-bottom: 15px;
    }

    .danger {
      background: #fef2f2;
      color: #b91c1c;
    }

    .success {
      background: #f0fdf4;
      color: #166534;
    }

    .remember {
      display: flex;
      align-items: center;
    }

    .remember label {
      display: flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap; /* ini biar tidak turun ke bawah */
      font-size: 14px;
      cursor: pointer;
    }

  </style>
</head>

<body>

<div class="login-card">

  <div class="welcome">Selamat Datang</div>
  <h2>Masuk ke Akun Anda</h2>
  <p>Silakan login untuk melanjutkan ke sistem perpustakaan.</p>

  @if(session('error'))
    <div class="alert danger">{{ session('error') }}</div>
  @endif

  @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('login.proses') }}" method="post">
    @csrf

    <div class="form-group">
      <label>Email</label>
      <div class="input-wrap">
        <i class="bi bi-envelope"></i>
        <input type="email" name="email" value="{{ old('email') }}">
      </div>
    </div>

    <div class="form-group">
      <label>Password</label>
      <div class="input-wrap">
        <i class="bi bi-lock"></i>
        <input type="password" name="password">
      </div>
    </div>

    <div class="remember">
      <label>
        <input type="checkbox" name="remember">
        <span>Ingat saya</span>
      </label>
    </div>

    <button type="submit">Masuk</button>
  </form>

  <div class="footer">
    Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
  </div>

</div>

</body>
</html>