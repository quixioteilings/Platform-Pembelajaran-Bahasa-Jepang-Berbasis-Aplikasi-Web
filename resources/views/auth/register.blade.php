<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Akun Siswa Baru - SIJapanese</title>
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
      --border: #CBD5E1;
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
    .register-container {
      width: 100%;
      max-width: 500px;
    }
    .register-card {
      background: #FFFFFF;
      border: 1.5px solid #E2E8F0;
      border-radius: 24px;
      padding: 2.2rem 2rem;
      box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.10);
      position: relative;
    }
    .header {
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
    .header-title {
      font-size: 1.6rem;
      font-weight: 800;
      letter-spacing: -0.02em;
      color: var(--text);
    }
    .header-title span {
      color: var(--red);
    }
    .header-sub {
      color: var(--text-soft);
      font-size: 0.88rem;
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
      background: #FEF2F2;
      border: 1.5px solid #FECACA;
      color: #DC2626;
      line-height: 1.4;
    }
    .alert-icon-svg {
      width: 18px;
      height: 18px;
      flex-shrink: 0;
      margin-top: 1px;
    }
    .form-group {
      margin-bottom: 1.15rem;
      display: flex;
      flex-direction: column;
      gap: 0.45rem;
    }
    .form-row-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.85rem;
    }
    .form-group label {
      font-size: 0.86rem;
      font-weight: 700;
      color: #334155;
    }
    .form-group input,
    .form-group select {
      width: 100%;
      padding: 0.85rem 1rem;
      border: 1.5px solid var(--border);
      border-radius: 12px;
      font-size: 0.95rem;
      font-family: inherit;
      color: var(--text);
      background: #FFFFFF;
      outline: none;
      transition: all 0.2s ease;
    }
    .input-pass-wrap {
      position: relative;
      width: 100%;
    }
    .input-pass-wrap input {
      padding-right: 2.85rem;
    }
    .form-group input:focus,
    .form-group select:focus {
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

    /* Avatar Grid Selector */
    .avatar-cards-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.75rem;
      margin-top: 0.25rem;
    }
    .avatar-card-item {
      cursor: pointer;
      position: relative;
    }
    .avatar-card-item input {
      position: absolute;
      opacity: 0;
      pointer-events: none;
    }
    .avatar-card-inner {
      border: 2px solid #E2E8F0;
      border-radius: 14px;
      padding: 0.75rem 0.5rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.35rem;
      background: #F8FAFC;
      transition: all 0.2s ease;
      text-align: center;
    }
    .avatar-card-inner img {
      width: 46px;
      height: 46px;
      border-radius: 50%;
      border: 1.5px solid #CBD5E1;
      object-fit: cover;
      display: block;
    }
    .avatar-card-name {
      font-size: 0.82rem;
      font-weight: 800;
      color: var(--text);
    }
    .avatar-card-role {
      font-size: 0.7rem;
      color: var(--text-soft);
    }
    .avatar-card-item input:checked + .avatar-card-inner {
      border-color: var(--red);
      background: #FEF2F2;
      box-shadow: 0 4px 12px rgba(217, 56, 58, 0.15);
    }

    .pass-match-msg {
      font-size: 0.78rem;
      font-weight: 700;
      margin-top: 0.25rem;
      display: none;
    }
    .pass-match-msg.match {
      color: #059669;
      display: block;
    }
    .pass-match-msg.mismatch {
      color: #DC2626;
      display: block;
    }

    .btn-submit {
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
      margin-top: 0.6rem;
    }
    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(217, 56, 58, 0.4);
    }
    .btn-submit:active {
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
      .register-card {
        padding: 1.8rem 1.3rem;
        border-radius: 20px;
      }
      .header-title {
        font-size: 1.45rem;
      }
      .form-row-2 {
        grid-template-columns: 1fr;
        gap: 0;
      }
      .form-group input,
      .form-group select {
        padding: 0.8rem 0.9rem;
        font-size: 0.92rem;
      }
      .btn-submit {
        padding: 0.85rem;
        font-size: 0.95rem;
      }
    }
  </style>
</head>
<body>

  <div class="register-container">
    <div class="register-card">
      <div class="header">
        <div class="logo-badge">
          <svg viewBox="0 0 32 32">
            <circle cx="16" cy="16" r="14" fill="#D9383A"/>
            <path d="M8 11h16M9 8v15M23 8v15M7 14h18" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <h1 class="header-title">SI<span>Japanese</span></h1>
        <p class="header-sub">Pendaftaran Akun Baru Siswa Belajar</p>
      </div>

      <!-- Flash Error Box (STRICT ZERO EMOJI) -->
      @if($errors->any())
      <div class="alert-box">
        <svg viewBox="0 0 24 24" class="alert-icon-svg" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>{{ $errors->first() }}</span>
      </div>
      @endif

      <form action="{{ route('register.post') }}" method="POST" id="main-reg-form">
        @csrf
        <input type="hidden" name="role" value="siswa" />

        <div class="form-group">
          <label for="reg-name">Nama Lengkap Siswa</label>
          <input type="text" name="name" id="reg-name" placeholder="contoh: Anggata Ramadhan" value="{{ old('name') }}" required autocomplete="name" />
        </div>

        <div class="form-row-2">
          <div class="form-group">
            <label for="reg-nisn">NISN / Nomor Induk Siswa</label>
            <input type="text" name="reg_no" id="reg-nisn" placeholder="contoh: 0071234567" value="{{ old('reg_no') }}" autocomplete="off" />
          </div>

          <div class="form-group">
            <label for="reg-class">Kelas / Rombel</label>
            <select name="class_room" id="reg-class">
              <option value="Kelas X-A">Kelas X-A</option>
              <option value="Kelas X-B">Kelas X-B</option>
              <option value="Kelas XI-A">Kelas XI-A</option>
              <option value="Kelas XI-B">Kelas XI-B</option>
              <option value="Kelas XII">Kelas XII</option>
              <option value="Siswa Umum">Siswa Umum / Mandiri</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="reg-email">Alamat Email</label>
          <input type="email" name="email" id="reg-email" placeholder="contoh: siswa@sekolah.sch.id" value="{{ old('email') }}" required autocomplete="email" />
        </div>

        <!-- Pilihan Avatar Interaktif Siswa -->
        <div class="form-group">
          <label>Pilihan Karakter Avatar Belajar Siswa:</label>
          <div class="avatar-cards-grid">
            <label class="avatar-card-item">
              <input type="radio" name="avatar" value="img/avatar_anggata.svg" checked />
              <div class="avatar-card-inner">
                <img src="{{ asset('img/avatar_anggata.svg') }}" alt="Anggata" />
                <span class="avatar-card-name">Anggata</span>
                <span class="avatar-card-role">Karakter Siswa</span>
              </div>
            </label>

            <label class="avatar-card-item">
              <input type="radio" name="avatar" value="img/avatar_aoi.svg" />
              <div class="avatar-card-inner">
                <img src="{{ asset('img/avatar_aoi.svg') }}" alt="Aoi" />
                <span class="avatar-card-name">Aoi</span>
                <span class="avatar-card-role">Karakter Siswi</span>
              </div>
            </label>
          </div>
        </div>

        <div class="form-row-2">
          <div class="form-group">
            <label for="reg-pass">Kata Sandi (Min. 6 Karakter)</label>
            <div class="input-pass-wrap">
              <input type="password" name="password" id="reg-pass" placeholder="Minimal 6 karakter..." required minlength="6" autocomplete="new-password" oninput="checkPassMatch()" />
              <button type="button" class="btn-toggle-pass" onclick="togglePassVisibility('reg-pass', this)" title="Lihat/Sembunyikan Sandi">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
          </div>

          <div class="form-group">
            <label for="reg-pass-confirm">Konfirmasi Kata Sandi</label>
            <div class="input-pass-wrap">
              <input type="password" name="password_confirmation" id="reg-pass-confirm" placeholder="Ulangi kata sandi..." required minlength="6" autocomplete="new-password" oninput="checkPassMatch()" />
              <button type="button" class="btn-toggle-pass" onclick="togglePassVisibility('reg-pass-confirm', this)" title="Lihat/Sembunyikan Sandi">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
          </div>
        </div>
        <div id="pass-match-indicator" class="pass-match-msg"></div>

        <button type="submit" class="btn-submit" id="btn-submit-reg">
          <span>Daftar Akun Siswa Baru</span>
          <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2.5;stroke-linecap:round;"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
      </form>

      <!-- Informasi Hak Akses Guru Pengajar -->
      <div style="margin-top: 1.4rem; padding: 0.85rem 1rem; border-radius: 14px; background: #F8FAFC; border: 1.5px solid #E2E8F0; font-size: 0.82rem; color: #475569; line-height: 1.45; display: flex; align-items: flex-start; gap: 0.65rem;">
        <svg viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;margin-top:2px;color:var(--red);" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
        <span>Pendaftaran ini khusus untuk <strong>Siswa Belajar</strong>. Akun Guru Pengajar dikelola secara terpusat oleh administrator instansi sekolah.</span>
      </div>

      <div class="bottom-links">
        <div>Sudah memiliki akun belajar? <a href="{{ route('login') }}">Masuk di sini</a></div>
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

    function checkPassMatch() {
      const p1 = document.getElementById('reg-pass').value;
      const p2 = document.getElementById('reg-pass-confirm').value;
      const ind = document.getElementById('pass-match-indicator');
      if (!p2) {
        ind.className = 'pass-match-msg';
        ind.textContent = '';
        return;
      }
      if (p1 === p2) {
        ind.className = 'pass-match-msg match';
        ind.textContent = 'Kata sandi cocok.';
      } else {
        ind.className = 'pass-match-msg mismatch';
        ind.textContent = 'Kata sandi belum sama.';
      }
    }
  </script>
</body>
</html>
