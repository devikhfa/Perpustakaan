<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Perpustakaan Masuk</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      background: #0f1b3d;
    }

    /* LEFT PANEL */
    .left-panel {
      flex: 1;
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 48px;
      overflow: hidden;
      min-height: 100vh;
    }

    .left-panel::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=900&auto=format&fit=crop&q=80');
      background-size: cover;
      background-position: center;
      filter: brightness(0.35);
      z-index: 0;
    }

    .left-panel::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(10,20,50,0.95) 0%, rgba(10,20,50,0.3) 60%, transparent 100%);
      z-index: 1;
    }

    .left-content {
      position: relative;
      z-index: 2;
    }

    .brand {
      position: absolute;
      top: 48px;
      left: 48px;
      z-index: 2;
      font-size: 22px;
      font-weight: 800;
      color: #fff;
      letter-spacing: 1px;
      text-decoration: none;
    }

    .brand span { color: #4e8ff8; }

    .left-tagline {
      font-size: 36px;
      font-weight: 800;
      color: #fff;
      line-height: 1.2;
      margin-bottom: 14px;
      letter-spacing: -0.5px;
    }

    .left-tagline span { color: #4e8ff8; }

    .left-desc {
      font-size: 14px;
      color: rgba(255,255,255,0.6);
      line-height: 1.7;
      max-width: 360px;
      margin-bottom: 32px;
    }

    .stats-row {
      display: flex;
      gap: 20px;
    }

    .stat-chip {
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 12px;
      padding: 12px 18px;
      backdrop-filter: blur(8px);
    }

    .stat-chip .num { font-size: 20px; font-weight: 800; color: #4e8ff8; }
    .stat-chip .lbl { font-size: 11px; color: rgba(255,255,255,0.5); margin-top: 2px; }

    /* RIGHT PANEL */
    .right-panel {
      width: 480px;
      min-height: 100vh;
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 56px 48px;
      flex-shrink: 0;
    }

    .form-header { margin-bottom: 36px; }
    .form-header .welcome { font-size: 13px; font-weight: 600; color: #4e8ff8; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 8px; }
    .form-header h2 { font-size: 26px; font-weight: 800; color: #111827; margin-bottom: 6px; letter-spacing: -0.3px; }
    .form-header p { font-size: 13.5px; color: #6b7280; line-height: 1.6; }

    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 12.5px; font-weight: 600; color: #374151; margin-bottom: 6px; }

    .input-wrap { position: relative; }
    .input-wrap i {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      font-size: 15px;
      pointer-events: none;
    }

    .form-input {
      width: 100%;
      padding: 11px 14px 11px 40px;
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      font-size: 13.5px;
      font-family: inherit;
      color: #111827;
      background: #fafafa;
      outline: none;
      transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
    }

    .form-input:focus {
      border-color: #4e8ff8;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(78,143,248,0.12);
    }

    .form-input.is-invalid { border-color: #ef4444; }

    .invalid-feedback {
      display: block;
      font-size: 12px;
      color: #ef4444;
      margin-top: 5px;
    }

    .remember-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }

    .remember-label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: #6b7280;
      cursor: pointer;
    }

    .remember-label input[type="checkbox"] {
      width: 15px; height: 15px;
      accent-color: #4e8ff8;
      cursor: pointer;
    }

    .btn-submit {
      width: 100%;
      padding: 12px;
      background: #2f6df6;
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 700;
      font-family: inherit;
      cursor: pointer;
      transition: background 0.18s, transform 0.1s;
      letter-spacing: 0.2px;
    }

    .btn-submit:hover { background: #1a5ce6; }
    .btn-submit:active { transform: scale(0.99); }

    .form-footer {
      text-align: center;
      margin-top: 24px;
      font-size: 13px;
      color: #6b7280;
    }

    .form-footer a {
      color: #2f6df6;
      font-weight: 600;
      text-decoration: none;
    }

    .form-footer a:hover { text-decoration: underline; }

    .alert-box {
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 13px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .alert-danger { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

    .divider { height: 1px; background: #f3f4f6; margin: 28px 0; }

    @media (max-width: 768px) {
      .left-panel { display: none; }
      .right-panel { width: 100%; padding: 40px 28px; }
    }
  </style>
</head>
<body>

{{-- LEFT PANEL --}}
<div class="left-panel">
  <div class="left-content">
    <div class="left-tagline">Web Perpustakaan<br><span>SMKN 3 Banjar</span></div>
    <p class="left-desc">Cari buku favoritmu, pinjam kapan aja, dan cek status pengembaliannya dengan mudah.</p>
    <div class="stats-row">
    </div>
  </div>
</div>

{{-- RIGHT PANEL --}}
<div class="right-panel">
  <div class="form-header">
    <div class="welcome">Selamat Datang</div>
    <h2>Masuk ke Akun Anda</h2>
    <p>Silakan masukkan email dan password untuk melanjutkan.</p>
  </div>

  @if(session('error'))
    <div class="alert-box alert-danger">
      <i class="bi bi-exclamation-circle-fill"></i>
      {{ session('error') }}
    </div>
  @endif

  @if(session('success'))
    <div class="alert-box alert-success">
      <i class="bi bi-check-circle-fill"></i>
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('login.proses') }}" method="post">
    @csrf

    <div class="form-group">
      <label class="form-label">Alamat Email</label>
      <div class="input-wrap">
        <i class="bi bi-envelope"></i>
        <input type="email" name="email"
               class="form-input @error('email') is-invalid @enderror"
               placeholder="contoh@email.com"
               value="{{ old('email') }}">
      </div>
      @error('email')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-group">
      <label class="form-label">Password</label>
      <div class="input-wrap">
        <i class="bi bi-lock"></i>
        <input type="password" name="password"
               class="form-input @error('password') is-invalid @enderror"
               placeholder="Masukkan password">
      </div>
      @error('password')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="remember-row">
      <label class="remember-label">
        <input type="checkbox" name="remember" id="remember">
        Ingat saya
      </label>
    </div>

    <button type="submit" class="btn-submit">Masuk</button>
  </form>

  <div class="divider"></div>

  <div class="form-footer">
    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
  </div>
</div>

</body>
</html>