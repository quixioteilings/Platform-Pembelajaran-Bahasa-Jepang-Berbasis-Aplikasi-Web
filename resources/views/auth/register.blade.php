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
      /* Warm Japanese Terracotta (Akane-iro) */
      --red: #BA5444;
      --red-light: #CA6757;
      --red-dark: #9A3F31;
      --red-pale: #FAF1EE;
      --red-border: #F1D6CF;

      /* Warm Muted Indigo */
      --blue: #3E6B89;
      --blue-light: #5281A1;
      --blue-dark: #2E5169;
      --blue-pale: #EFF4F8;
      --blue-border: #D1DFE9;

      /* Warm Matcha Green */
      --green: #437856;
      --green-pale: #F0F6F2;
      --green-border: #D0E4D7;

      /* Deep Warm Espresso Charcoal (Zero Glare) */
      --text: #2F2620;
      --text-soft: #6E6157;
      --text-light: #A3968B;

      /* Warm Washi Off-White (Kinari) - Harmonis dengan Dashboard & Profil */
      --bg: #F8F4EC;
      --bg-warm: #EFE8DC;
      --card: #FAF6F0;
      --card-warm: #F4EFE6;
      --card-inner: #EDE6DA;
      --border: #DFD7C8;
      --border-light: #EBE4D8;
    }
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: radial-gradient(circle at 10% 20%, #FAF1EE 0%, #F5EFE6 50%, #F8F4EC 100%);
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
      background: var(--card);
      border: 1.5px solid var(--border);
      border-radius: 24px;
      padding: 2.2rem 2rem;
      box-shadow: 0 20px 40px -15px rgba(60, 45, 30, 0.10);
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
      background: var(--red-pale);
      border: 2px solid var(--red-border);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 0.85rem;
      box-shadow: 0 4px 14px rgba(186, 84, 68, 0.15);
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
      background: #FAF1EE;
      border: 1.5px solid #F1D6CF;
      color: #BA5444;
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
      color: var(--text);
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
      background: #FDFBF7;
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
      background: #FFFFFF;
      box-shadow: 0 0 0 3px rgba(186, 84, 68, 0.12);
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
      color: var(--text-soft);
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      transition: color 0.15s ease;
    }
    .btn-toggle-pass:hover {
      color: var(--text);
    }

    /* Gender Cards Grid */
    .gender-cards-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.75rem;
      margin-top: 0.25rem;
    }
    .gender-card-item {
      cursor: pointer;
      position: relative;
    }
    .gender-card-item input {
      position: absolute;
      opacity: 0;
      pointer-events: none;
    }
    .gender-card-inner {
      border: 2px solid var(--border);
      border-radius: 14px;
      padding: 0.75rem 0.85rem;
      display: flex;
      align-items: center;
      gap: 0.65rem;
      background: var(--card-warm);
      transition: all 0.2s ease;
    }
    .gender-icon-wrap {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: var(--card);
      border: 1.5px solid var(--border);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: var(--text-soft);
      flex-shrink: 0;
      transition: all 0.2s ease;
    }
    .gender-title {
      font-size: 0.90rem;
      font-weight: 800;
      color: var(--text);
      display: block;
      line-height: 1.2;
    }
    .gender-sub {
      font-size: 0.72rem;
      color: var(--text-soft);
      font-weight: 600;
    }
    .gender-card-item input:checked + .gender-card-inner {
      border-color: var(--red);
      background: var(--red-pale);
      box-shadow: 0 4px 12px rgba(186, 84, 68, 0.12);
    }
    .gender-card-item input:checked + .gender-card-inner .gender-icon-wrap {
      background: var(--red-pale);
      border-color: var(--red-border);
      color: var(--red);
    }

    /* Custom Photo Upload Card */
    .upload-avatar-box {
      border: 1.5px dashed var(--border);
      border-radius: 14px;
      padding: 0.75rem 0.9rem;
      background: var(--card-warm);
      transition: all 0.2s ease;
    }
    .upload-avatar-box.has-file {
      border-color: var(--blue);
      background: var(--blue-pale);
    }
    .upload-avatar-row {
      display: flex;
      align-items: center;
      gap: 0.85rem;
    }
    .upload-avatar-preview {
      width: 46px;
      height: 46px;
      border-radius: 50%;
      border: 2px solid var(--border);
      overflow: hidden;
      flex-shrink: 0;
      background: var(--card);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .upload-avatar-preview img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    .upload-avatar-info {
      flex: 1;
      min-width: 0;
    }
    .upload-avatar-title {
      font-size: 0.84rem;
      font-weight: 700;
      color: var(--text);
    }
    .upload-avatar-desc {
      font-size: 0.72rem;
      color: var(--text-soft);
      margin-bottom: 0.35rem;
    }
    .upload-avatar-btns {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .btn-choose-file {
      padding: 0.35rem 0.75rem;
      border-radius: 8px;
      font-size: 0.78rem;
      font-weight: 700;
      font-family: inherit;
      background: var(--card);
      border: 1.5px solid var(--border);
      color: var(--text);
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      transition: all 0.15s ease;
    }
    .btn-choose-file:hover {
      border-color: var(--blue);
      color: var(--blue);
      background: #FFFFFF;
    }
    .btn-cancel-custom-photo {
      padding: 0.35rem 0.6rem;
      border-radius: 8px;
      font-size: 0.75rem;
      font-weight: 700;
      font-family: inherit;
      background: var(--red-pale);
      border: 1px solid var(--red-border);
      color: var(--red);
      cursor: pointer;
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
      box-shadow: 0 4px 14px rgba(186, 84, 68, 0.28);
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 0.6rem;
    }
    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(186, 84, 68, 0.38);
    }
    .btn-submit:active {
      transform: translateY(0);
    }
    .bottom-links {
      margin-top: 1.8rem;
      padding-top: 1.25rem;
      border-top: 1.5px solid var(--border-light);
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
            <circle cx="16" cy="16" r="14" fill="#BA5444"/>
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

      <form action="{{ route('register.post') }}" method="POST" id="main-reg-form" enctype="multipart/form-data">
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

        <!-- Pilihan Jenis Kelamin (Gender) Siswa -->
        <div class="form-group">
          <label>Jenis Kelamin Siswa Belajar:</label>
          <div class="gender-cards-grid">
            <label class="gender-card-item">
              <input type="radio" name="gender" value="Laki-laki (MALE)" checked />
              <div class="gender-card-inner">
                <div class="gender-icon-wrap">
                  <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="10" cy="14" r="5"/>
                    <line x1="19" y1="5" x2="13.6" y2="10.4"/>
                    <line x1="19" y1="5" x2="14" y2="5"/>
                    <line x1="19" y1="5" x2="19" y2="10"/>
                  </svg>
                </div>
                <div>
                  <span class="gender-title">Laki-laki</span>
                  <span class="gender-sub">Siswa (MALE)</span>
                </div>
              </div>
            </label>

            <label class="gender-card-item">
              <input type="radio" name="gender" value="Perempuan (FEMALE)" />
              <div class="gender-card-inner">
                <div class="gender-icon-wrap">
                  <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="9" r="5"/>
                    <line x1="12" y1="14" x2="12" y2="21"/>
                    <line x1="9" y1="18" x2="15" y2="18"/>
                  </svg>
                </div>
                <div>
                  <span class="gender-title">Perempuan</span>
                  <span class="gender-sub">Siswi (FEMALE)</span>
                </div>
              </div>
            </label>
          </div>
        </div>

        <!-- Foto Profil Siswa (Opsional - Default Anonim) -->
        <div class="form-group">
          <label>Foto Profil Siswa (Opsional):</label>
          <input type="hidden" name="avatar" value="img/avatar_default.svg" id="reg-avatar-val" />
          <div class="upload-avatar-box" id="upload-avatar-wrap">
            <input type="file" name="avatar_file" id="reg-avatar-file" accept="image/jpeg,image/png,image/webp,image/jpg" style="display:none;" onchange="handleRegisterPhotoUpload(this)" />
            <div class="upload-avatar-row">
              <div class="upload-avatar-preview">
                <img id="upload-avatar-preview-img" src="{{ asset('img/avatar_default.svg') }}" alt="Foto Profil Siswa" />
              </div>
              <div class="upload-avatar-info">
                <div class="upload-avatar-title">Foto Profil Anonim (Default)</div>
                <div class="upload-avatar-desc">Format JPG, PNG, atau WebP (Maksimal 3MB)</div>
                <div class="upload-avatar-btns">
                  <button type="button" class="btn-choose-file" onclick="document.getElementById('reg-avatar-file').click()">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <span>Upload Foto Sendiri</span>
                  </button>
                  <button type="button" class="btn-cancel-custom-photo" id="btn-cancel-photo" style="display:none;" onclick="resetToAnonymousPhoto()">
                    Batal
                  </button>
                </div>
              </div>
            </div>
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
      <div style="margin-top: 1.4rem; padding: 0.85rem 1rem; border-radius: 14px; background: var(--card-warm); border: 1.5px solid var(--border); font-size: 0.82rem; color: var(--text-soft); line-height: 1.45; display: flex; align-items: flex-start; gap: 0.65rem;">
        <svg viewBox="0 0 24 24" style="width:18px;height:18px;flex-shrink:0;margin-top:2px;color:var(--red);" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
        <span>Pendaftaran ini khusus untuk <strong style="color:var(--text);">Siswa Belajar</strong>. Akun Guru Pengajar dikelola secara terpusat oleh administrator instansi sekolah.</span>
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

    function handleRegisterPhotoUpload(input) {
      const file = input.files && input.files[0];
      if (!file) return;

      if (!file.type.startsWith('image/')) {
        alert('Silakan pilih file foto gambar (JPG, PNG, WebP).');
        input.value = '';
        return;
      }

      if (file.size > 3 * 1024 * 1024) {
        alert('Ukuran foto terlalu besar. Maksimal 3MB.');
        input.value = '';
        return;
      }

      const reader = new FileReader();
      reader.onload = function(e) {
        const previewImg = document.getElementById('upload-avatar-preview-img');
        if (previewImg) previewImg.src = e.target.result;
        
        document.getElementById('upload-avatar-wrap')?.classList.add('has-file');
        const cancelBtn = document.getElementById('btn-cancel-photo');
        if (cancelBtn) cancelBtn.style.display = 'inline-block';
      };
      reader.readAsDataURL(file);
    }

    function resetToAnonymousPhoto() {
      const fileInput = document.getElementById('reg-avatar-file');
      if (fileInput) fileInput.value = '';

      document.getElementById('upload-avatar-wrap')?.classList.remove('has-file');
      const cancelBtn = document.getElementById('btn-cancel-photo');
      if (cancelBtn) cancelBtn.style.display = 'none';

      const previewImg = document.getElementById('upload-avatar-preview-img');
      if (previewImg) previewImg.src = "{{ asset('img/avatar_default.svg') }}";
    }
  </script>
</body>
</html>
