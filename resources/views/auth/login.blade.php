<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk Portal Siswa &amp; Guru - SIJapanese</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet" />
  <style>
    :root {
      --red: #D9383A;
      --red-dark: #B91C1C;
      --blue: #2563EB;
      --blue-dark: #1D4ED8;
      --green: #10B981;
      --text: #0F172A;
      --text-soft: #64748B;
      --bg: #F8FAFC;
    }
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: radial-gradient(circle at 10% 20%, #FEE2E2 0%, #EFF6FF 50%, #F8FAFC 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px 16px;
      color: var(--text);
    }
    .login-container {
      width: 100%;
      max-width: 480px;
    }
    .login-card {
      background: #FFFFFF;
      border: 1.5px solid #E2E8F0;
      border-radius: 24px;
      padding: 2.2rem 2rem;
      box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.10);
      position: relative;
    }
    .login-header {
      text-align: center;
      margin-bottom: 1.8rem;
    }
    .logo-badge {
      width: 58px;
      height: 58px;
      border-radius: 18px;
      background: #FEF2F2;
      border: 2px solid #FECACA;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 0.85rem;
      box-shadow: 0 4px 14px rgba(217, 56, 58, 0.15);
    }
    .logo-badge svg {
      width: 32px;
      height: 32px;
    }
    .login-title {
      font-size: 1.6rem;
      font-weight: 800;
      color: var(--text);
      letter-spacing: -0.02em;
    }
    .login-title span {
      color: var(--red);
    }
    .login-sub {
      font-size: 0.88rem;
      color: var(--text-soft);
      margin-top: 0.35rem;
    }
    .alert-box {
      padding: 0.85rem 1rem;
      border-radius: 12px;
      font-size: 0.86rem;
      font-weight: 700;
      margin-bottom: 1.25rem;
      display: flex;
      align-items: flex-start;
      gap: 0.65rem;
      line-height: 1.4;
    }
    .alert-icon-svg {
      width: 18px;
      height: 18px;
      flex-shrink: 0;
      margin-top: 1px;
    }
    .alert-error {
      background: #FEF2F2;
      border: 1.5px solid #FECACA;
      color: #DC2626;
    }
    .alert-warning {
      background: #FFFBEB;
      border: 1.5px solid #FDE68A;
      color: #D97706;
    }
    .alert-success {
      background: #ECFDF5;
      border: 1.5px solid #A7F3D0;
      color: #065F46;
    }
    .form-group {
      margin-bottom: 1.15rem;
      display: flex;
      flex-direction: column;
      gap: 0.45rem;
    }
    .form-group label {
      font-size: 0.86rem;
      font-weight: 700;
      color: #334155;
    }
    .input-pass-wrap {
      position: relative;
      width: 100%;
    }
    .form-group input {
      width: 100%;
      padding: 0.85rem 1rem;
      border: 1.5px solid #CBD5E1;
      border-radius: 12px;
      font-size: 0.95rem;
      font-family: inherit;
      color: var(--text);
      background: #FFFFFF;
      transition: all 0.2s ease;
      outline: none;
    }
    .input-pass-wrap input {
      padding-right: 2.85rem;
    }
    .form-group input:focus {
      border-color: var(--red);
      box-shadow: 0 0 0 3px rgba(217, 56, 58, 0.12);
    }
    .btn-toggle-pass {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      padding: 6px;
      cursor: pointer;
      color: #64748B;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      transition: color 0.15s ease;
    }
    .btn-toggle-pass:hover {
      color: var(--text);
    }
    .form-extras-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 0.85rem;
      font-size: 0.84rem;
    }
    .remember-wrap {
      display: inline-flex;
      align-items: center;
      gap: 0.45rem;
      color: #475569;
      cursor: pointer;
      user-select: none;
      font-weight: 600;
    }
    .remember-wrap input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: var(--red);
      cursor: pointer;
    }
    .btn-submit-login {
      width: 100%;
      padding: 0.9rem 1.2rem;
      background: linear-gradient(135deg, var(--red) 0%, var(--red-dark) 100%);
      color: #FFFFFF;
      border: none;
      border-radius: 14px;
      font-size: 1rem;
      font-weight: 800;
      cursor: pointer;
      box-shadow: 0 4px 14px rgba(217, 56, 58, 0.3);
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }
    .btn-submit-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(217, 56, 58, 0.4);
    }
    .btn-submit-login:active {
      transform: translateY(0);
    }

    .bottom-links {
      margin-top: 1.8rem;
      padding-top: 1.25rem;
      border-top: 1.5px solid #F1F5F9;
      text-align: center;
      font-size: 0.88rem;
      color: var(--text-soft);
      display: flex;
      flex-direction: column;
      gap: 0.65rem;
    }
    .bottom-links a {
      color: var(--blue);
      font-weight: 700;
      text-decoration: none;
      transition: color 0.15s ease;
    }
    .bottom-links a:hover {
      color: var(--blue-dark);
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      body {
        padding: 16px 12px;
      }
      .login-card {
        padding: 1.8rem 1.3rem;
        border-radius: 20px;
      }
      .login-title {
        font-size: 1.45rem;
      }
      .form-group input {
        font-size: 0.92rem;
        padding: 0.8rem 0.9rem;
      }
      .btn-submit-login {
        padding: 0.85rem;
        font-size: 0.95rem;
      }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <div class="logo-badge">
          <svg viewBox="0 0 32 32">
            <circle cx="16" cy="16" r="14" fill="#D9383A"/>
            <path d="M8 11h16M9 8v15M23 8v15M7 14h18" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <h1 class="login-title">SI<span>Japanese</span></h1>
        <p class="login-sub">Masuk ke Portal Siswa &amp; Dashboard Guru</p>
      </div>

      <!-- Flash Alerts (STRICT ZERO EMOJI) -->
      @if(session('error'))
      <div class="alert-box alert-error">
        <svg viewBox="0 0 24 24" class="alert-icon-svg" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>{{ session('error') }}</span>
      </div>
      @endif

      @if(session('warning'))
      <div class="alert-box alert-warning">
        <svg viewBox="0 0 24 24" class="alert-icon-svg" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        <span>{{ session('warning') }}</span>
      </div>
      @endif

      @if(session('success'))
      <div class="alert-box alert-success">
        <svg viewBox="0 0 24 24" class="alert-icon-svg" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        <span>{{ session('success') }}</span>
      </div>
      @endif

      @if($errors->any())
      <div class="alert-box alert-error">
        <svg viewBox="0 0 24 24" class="alert-icon-svg" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>{{ $errors->first() }}</span>
      </div>
      @endif

      <!-- Form Login -->
      <form action="{{ route('login.post') }}" method="POST" id="main-login-form">
        @csrf

        <div class="form-group">
          <label for="input-email">Alamat Email atau NISN Siswa</label>
          <input type="text" name="email" id="input-email" placeholder="contoh: siswa@sekolah.sch.id atau NISN" value="{{ old('email') }}" required autofocus autocomplete="username" />
        </div>

        <div class="form-group">
          <label for="input-password">Kata Sandi</label>
          <div class="input-pass-wrap">
            <input type="password" name="password" id="input-password" placeholder="Masukkan kata sandi..." required autocomplete="current-password" />
            <button type="button" class="btn-toggle-pass" onclick="togglePassVisibility('input-password', this)" title="Lihat/Sembunyikan Sandi">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
        </div>

        <div class="form-extras-row">
          <label class="remember-wrap">
            <input type="checkbox" name="remember" value="1" checked />
            <span>Ingat Saya di Perangkat Ini</span>
          </label>
        </div>

        <button type="submit" class="btn-submit-login" id="btn-login-submit">
          <span>Masuk Sekarang</span>
          <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2.5;stroke-linecap:round;"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
      </form>

      <div class="bottom-links">
        <div>Belum memiliki akun siswa? <a href="{{ route('register') }}">Daftar Akun Baru</a></div>
        <div><a href="{{ route('home') }}">Kembali ke Beranda</a></div>
      </div>
    </div>
  </div>

  <script>
    function togglePassVisibility(inputId, btn) {
      const input = document.getElementById(inputId);
      if (!input) return;
      if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = `<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`;
      } else {
        input.type = 'password';
        btn.innerHTML = `<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
      }
    }
  </script>
</body>
</html>
