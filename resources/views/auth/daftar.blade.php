<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LibTrack – Daftar</title>
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
    background-image: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=900&auto=format&fit=crop&q=80');
    background-size: cover;
    background-position: center;
    filter: brightness(0.3);
    z-index: 0;
    }

    .left-panel::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(10,20,50,0.95) 0%, rgba(10,20,50,0.3) 60%, transparent 100%);
      z-index: 1;
    }

    .left-content { position: relative; z-index: 2; }

    .brand {
      position: absolute;
      top: 48px; left: 48px;
      z-index: 2;
      font-size: 22px;
      font-weight: 800;
      color: #fff;
      letter-spacing: 1px;
      text-decoration: none;
    }
    .brand span { color: #4e8ff8; }

    .left-tagline { font-size: 34px; font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 14px; letter-spacing: -0.5px; }
    .left-tagline span { color: #4e8ff8; }
    .left-desc { font-size: 14px; color: rgba(255,255,255,0.6); line-height: 1.7; max-width: 360px; margin-bottom: 32px; }

    .step-list { display: flex; flex-direction: column; gap: 14px; }
    .step-item { display: flex; align-items: flex-start; gap: 12px; }
    .step-num {
      width: 28px; height: 28px;
      background: #2f6df6;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 12px; font-weight: 800; color: #fff;
      flex-shrink: 0;
    }
    .step-text { font-size: 13px; color: rgba(255,255,255,0.7); line-height: 1.5; padding-top: 4px; }

    .right-panel {
      width: 500px;
      min-height: 100vh;
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 48px;
      flex-shrink: 0;
    }

    .form-header { margin-bottom: 28px; }
    .form-header .welcome { font-size: 13px; font-weight: 600; color: #4e8ff8; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 8px; }
    .form-header h2 { font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 6px; letter-spacing: -0.3px; }
    .form-header p { font-size: 13px; color: #6b7280; }

    .form-group { margin-bottom: 16px; }
    .form-label { display: block; font-size: 12.5px; font-weight: 600; color: #374151; margin-bottom: 6px; }

    .input-wrap { position: relative; }
    .input-wrap i {
      position: absolute; left: 14px; top: 50%;
      transform: translateY(-50%);
      color: #9ca3af; font-size: 15px; pointer-events: none;
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
    .form-input:focus { border-color: #4e8ff8; background: #fff; box-shadow: 0 0 0 3px rgba(78,143,248,0.12); }
    .form-input.is-invalid { border-color: #ef4444; }

    textarea.form-input { padding-top: 11px; resize: none; }

    .invalid-feedback { display: block; font-size: 12px; color: #ef4444; margin-top: 5px; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

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
      margin-top: 8px;
    }
    .btn-submit:hover { background: #1a5ce6; }
    .btn-submit:active { transform: scale(0.99); }

    .alert-box {
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 13px;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .alert-danger { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    .divider { height: 1px; background: #f3f4f6; margin: 22px 0; }

    .form-footer { text-align: center; font-size: 13px; color: #6b7280; }
    .form-footer a { color: #2f6df6; font-weight: 600; text-decoration: none; }
    .form-footer a:hover { text-decoration: underline; }

    @media (max-width: 768px) {
      .left-panel { display: none; }
      .right-panel { width: 100%; padding: 36px 24px; }
      .form-row { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

{{-- LEFT PANEL --}}
<div class="left-panel">
  <div class="left-content">
    <div class="left-tagline">Mulai Perjalanan<br><span>Membacamu</span> Sekarang</div>
    <p class="left-desc">Daftar dan nikmati kemudahan meminjam buku dari perpustakaan SMKN 3 Banjar kapan saja.</p>
    <div class="step-list">
      <div class="step-item">
        <div class="step-num">1</div>
        <div class="step-text">Isi formulir pendaftaran dengan data diri kamu</div>
      </div>
      <div class="step-item">
        <div class="step-num">2</div>
        <div class="step-text">Akun langsung aktif setelah pendaftaran</div>
      </div>
      <div class="step-item">
        <div class="step-num">3</div>
        <div class="step-text">Mulai pinjam buku favorit kamu!</div>
      </div>
    </div>
  </div>
</div>

{{-- RIGHT PANEL --}}
<div class="right-panel">
  <div class="form-header">
    <div class="welcome">Buat Akun Baru</div>
    <h2>Daftar ke LibTrack</h2>
    <p>Lengkapi data di bawah untuk membuat akun.</p>
  </div>

  @if(session('error'))
    <div class="alert-box alert-danger">
      <i class="bi bi-exclamation-circle-fill"></i>
      {{ session('error') }}
    </div>
  @endif

  <form action="{{ route('register.proses') }}" method="post">
    @csrf

    <div class="form-group">
      <label class="form-label">Nama Lengkap</label>
      <div class="input-wrap">
        <i class="bi bi-person"></i>
        <input type="text" name="nama_pengguna"
               class="form-input @error('nama_pengguna') is-invalid @enderror"
               placeholder="Masukkan nama lengkap"
               value="{{ old('nama_pengguna') }}">
      </div>
      @error('nama_pengguna')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

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
      <label class="form-label">Alamat</label>
      <div class="input-wrap">
        <i class="bi bi-geo-alt" style="top: 14px; transform: none;"></i>
        <textarea name="alamat" rows="2"
                  class="form-input @error('alamat') is-invalid @enderror"
                  placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
      </div>
      @error('alamat')
        <span class="invalid-feedback">{{ $message }}</span>
      @enderror
    </div>

    <div class="form-row">
      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label">Password</label>
        <div class="input-wrap">
          <i class="bi bi-lock"></i>
          <input type="password" name="password"
                 class="form-input @error('password') is-invalid @enderror"
                 placeholder="Min. 6 karakter">
        </div>
        @error('password')
          <span class="invalid-feedback">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group" style="margin-bottom:0;">
        <label class="form-label">Konfirmasi Password</label>
        <div class="input-wrap">
          <i class="bi bi-lock-fill"></i>
          <input type="password" name="password_confirmation"
                 class="form-input"
                 placeholder="Ulangi password">
        </div>
      </div>
    </div>

    <button type="submit" class="btn-submit">Buat Akun</button>
  </form>

  <div class="divider"></div>

  <div class="form-footer">
    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
  </div>
</div>

</body>
</html>