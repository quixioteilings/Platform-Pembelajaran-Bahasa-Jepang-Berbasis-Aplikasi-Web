// ====================================================
// SIJapanese - User Authentication, Session & Modal
// Dirancang Khusus untuk Kebutuhan Murid Sekolah & Guru
// ZERO ICONS / ZERO EMOJIS (Semua Berbasis Vektor SVG Bersih)
// ====================================================

const DEMO_ACCOUNTS = {
  guru: {
    id: 1,
    name: 'Sensei Tanaka',
    email: 'guru@sijapanese.sch.id',
    password: 'password',
    role: 'guru',
    avatar: 'img/avatar_default.svg',
    reg_no: 'SIJ-2026-GURU01',
    gender: 'Laki-laki (MALE)',
    birthdate: '1988/04/12',
    class_room: 'Guru',
    score: 999,
    completed_quests: 12
  },
  kenji: {
    id: 2,
    name: 'Anggata Al Haadi Ramadhan',
    email: 'kenji@sijapanese.sch.id',
    password: 'password',
    role: 'siswa',
    avatar: 'img/avatar_anggata.svg',
    reg_no: 'JFT-2026-51720',
    gender: 'Laki-laki (MALE)',
    birthdate: '2007/09/16',
    class_room: 'Kelas X-A',
    score: 1250,
    completed_quests: 4
  },
  aoi: {
    id: 3,
    name: 'Aoi Sorano',
    email: 'aoi@sijapanese.sch.id',
    password: 'password',
    role: 'siswa',
    avatar: 'img/avatar_aoi.svg',
    reg_no: 'JFT-2026-51721',
    gender: 'Perempuan (FEMALE)',
    birthdate: '2008/01/20',
    class_room: 'Kelas X-B',
    score: 480,
    completed_quests: 2
  }
};

function resolveAuthUrl(target) {
  const isLaravel = (typeof window !== 'undefined' && typeof window.LARAVEL_USER !== 'undefined') || 
                    window.location.port === '8000' || 
                    window.location.port === '8080' ||
                    window.location.pathname.startsWith('/guru') ||
                    window.location.pathname.startsWith('/login') ||
                    window.location.pathname.startsWith('/register');
  
  if (isLaravel) {
    if (target === 'login') return '/login';
    if (target === 'register') return '/register';
    if (target === 'guru') return '/guru';
    return '/';
  }

  // Static / XAMPP subfolder mode
  const path = window.location.pathname;
  const isHtml = path.endsWith('.html');
  const baseDir = path.substring(0, path.lastIndexOf('/') + 1);

  if (target === 'login') return isHtml || baseDir ? (baseDir + 'login.html') : 'login.html';
  if (target === 'register') return isHtml || baseDir ? (baseDir + 'register.html') : 'register.html';
  if (target === 'guru') return isHtml || baseDir ? (baseDir + 'guru.html') : 'guru.html';
  return isHtml || baseDir ? (baseDir + 'index.html') : 'index.html';
}

function getSavedUser() {
  // 1. Cek sesi Laravel jika disuntikkan via window.LARAVEL_USER
  if (typeof window !== 'undefined' && window.LARAVEL_USER !== undefined && window.LARAVEL_USER !== null) {
    try {
      localStorage.setItem('sijapanese_active_user', JSON.stringify(window.LARAVEL_USER));
      localStorage.setItem('sijapanese_auth_user', JSON.stringify(window.LARAVEL_USER));
    } catch (e) {}
    return window.LARAVEL_USER;
  }

  // 2. Cek local storage (mode statis/offline)
  try {
    const saved = localStorage.getItem('sijapanese_active_user') || localStorage.getItem('sijapanese_auth_user');
    if (saved) {
      const parsed = JSON.parse(saved);
      if (parsed && parsed.email) {
        if (!parsed.avatar || parsed.avatar.length <= 4) {
          parsed.avatar = 'img/avatar_default.svg';
        }
        return parsed;
      }
    }
  } catch (e) {}

  return null;
}

let currentUser = getSavedUser();
let isUserLoggedIn = currentUser !== null;

if (typeof document !== 'undefined') {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAuthSystem);
  } else {
    initAuthSystem();
  }
}

function initAuthSystem() {
  currentUser = getSavedUser();
  isUserLoggedIn = currentUser !== null;
  injectAuthModals();
  renderUserWidget();
}

// Helper untuk render elemen avatar (Mendukung SVG / PNG / JPG / WebP gambar, Base64 maupun teks)
function renderAvatarHtml(avatar, altText = 'Avatar', extraClass = '') {
  if (!avatar) {
    return `<img src="img/avatar_default.svg" alt="${escapeHtml(altText)}" class="${extraClass}" style="object-fit:cover;" />`;
  }
  const isImage = avatar.startsWith('img/') || 
                  avatar.startsWith('uploads/') || 
                  avatar.startsWith('/') || 
                  avatar.startsWith('http://') || 
                  avatar.startsWith('https://') || 
                  avatar.startsWith('data:image/') || 
                  /\.(svg|png|jpg|jpeg|webp|gif)(\?.*)?$/i.test(avatar);

  if (isImage) {
    return `<img src="${avatar}" alt="${escapeHtml(altText)}" class="${extraClass}" style="object-fit:cover;" onerror="this.onerror=null;this.src='img/avatar_default.svg';" />`;
  }
  return `<span class="${extraClass}">${escapeHtml(avatar)}</span>`;
}

// ====================================================
// RENDER BUBBLE PROFIL DI NAVBAR
// ====================================================
function renderUserWidget() {
  const container = document.getElementById('nav-user-widget');
  if (!container) return;

  if (!isUserLoggedIn || !currentUser) {
    const loginUrl = resolveAuthUrl('login');
    const registerUrl = resolveAuthUrl('register');

    container.innerHTML = `
      <div class="nav-auth-wrap not-logged-in" style="display:flex; align-items:center; gap:0.5rem;">
        <a href="${loginUrl}" class="btn-nav-masuk" style="text-decoration:none; padding:0.4rem 0.95rem; border-radius:9999px; font-weight:700; font-size:0.85rem; border:1.5px solid #CBD5E1; color:#1E293B; background:transparent;">Masuk</a>
        <a href="${registerUrl}" class="btn-nav-daftar" style="text-decoration:none; padding:0.4rem 0.95rem; border-radius:9999px; font-weight:700; font-size:0.85rem; border:1.5px solid #D9383A; color:#FFFFFF; background:#D9383A;">Daftar</a>
      </div>
    `;
    return;
  }

  const isGuru = currentUser.role === 'guru';
  const firstName = currentUser.name ? currentUser.name.split(' ')[0] : 'User';
  const avatarPath = currentUser.avatar || 'img/avatar_default.svg';

  container.innerHTML = `
    <div class="nav-auth-wrap">
      <!-- Poin Siswa Kompak -->
      <div class="nav-score-compact" title="Total Poin Belajar: ${currentUser.score || 0}">
        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        <span>${currentUser.score || 0}</span>
      </div>

      <!-- Bubble Profil (Klik untuk membuka profil peserta & sertifikat) -->
      <button class="nav-profile-bubble-btn ${isGuru ? 'is-guru' : ''}" onclick="openProfileModal()" title="Profil: ${escapeHtml(currentUser.name)} - Klik untuk melihat rapor &amp; identitas">
        <div class="bubble-avatar-circle">
          ${renderAvatarHtml(avatarPath, currentUser.name)}
        </div>
        <span class="bubble-name-text">${escapeHtml(firstName)}</span>
        <svg viewBox="0 0 24 24" class="svg-caret-mini"><polyline points="6 9 12 15 18 9"/></svg>
      </button>
    </div>
  `;
}

// ====================================================
// FUNGSI ANIMASI LOADING TRANSISI TIAP PINDAH LOGIN / AKUN
// ====================================================
function showLoadingOverlay(title, sub, avatar, duration = 650) {
  const overlay = document.getElementById('sij-loading-overlay');
  if (!overlay) return Promise.resolve();

  document.getElementById('sij-loading-title').textContent = title;
  document.getElementById('sij-loading-sub').textContent = sub;
  
  const avatarContainer = document.getElementById('sij-loading-avatar');
  if (avatarContainer) {
    if (avatar && (avatar.startsWith('img/') || avatar.startsWith('/') || avatar.endsWith('.svg') || avatar.endsWith('.png'))) {
      avatarContainer.innerHTML = `<img src="${avatar}" alt="Avatar" style="width:38px;height:38px;border-radius:50%;object-fit:cover;display:block;" />`;
    } else {
      avatarContainer.innerHTML = `<svg viewBox="0 0 24 24" style="width:28px;height:28px;fill:#D9383A;"><circle cx="12" cy="12" r="10"/></svg>`;
    }
  }

  const fill = overlay.querySelector('.sij-loading-progress-fill');
  if (fill) {
    fill.style.animation = 'none';
    fill.offsetHeight;
    fill.style.animation = `fillProgress ${duration / 1000}s ease forwards`;
  }

  overlay.classList.add('show');

  return new Promise(resolve => {
    setTimeout(() => {
      overlay.classList.remove('show');
      setTimeout(resolve, 150);
    }, duration);
  });
}

// ====================================================
// INJEKSI MODAL PROFIL, LOGIN & LOADING OVERLAY
// ====================================================
function injectAuthModals() {
  if (document.getElementById('modal-user-profile')) return;

  const guruUrl = resolveAuthUrl('guru');

  const modalHtml = `
    <!-- LOADING OVERLAY ANIMASI (TIAP PINDAH LOGIN / AKUN) -->
    <div class="sij-loading-overlay" id="sij-loading-overlay">
      <div class="sij-loading-card">
        <div class="sij-spinner-ring">
          <div class="sij-spinner-inner">
            <span id="sij-loading-avatar">
              <svg viewBox="0 0 24 24" style="width:26px;height:26px;fill:#D9383A;"><circle cx="12" cy="12" r="10"/></svg>
            </span>
          </div>
        </div>
        <h4 class="sij-loading-title" id="sij-loading-title">Memuat Akun...</h4>
        <p class="sij-loading-sub" id="sij-loading-sub">Mohon tunggu sebentar...</p>
        <div class="sij-loading-progress-bar">
          <div class="sij-loading-progress-fill"></div>
        </div>
      </div>
    </div>

    <!-- MODAL PROFIL PESERTA & SERTIFIKAT (MUNCUL PAS MENCET PROFIL) -->
    <div class="sij-modal-backdrop" id="modal-user-profile" onclick="handleBackdropClick(event, 'modal-user-profile')">
      <div class="sij-modal-card">
        <div class="sij-modal-header">
          <div class="sij-modal-titles">
            <h3>Profil Peserta &amp; Sertifikat</h3>
            <p>Data resmi yang tercetak pada rapor &amp; kemajuan belajar</p>
          </div>
          <button class="sij-modal-close-btn" onclick="closeProfileModal()">&times;</button>
        </div>

        <div class="sij-modal-body">
          <!-- Informasi Akun Pengguna -->
          <div id="prof-role-banner" style="background:#F8FAFC; border:1.5px solid #E2E8F0; border-radius:14px; padding:0.75rem 1rem; margin-bottom:1.15rem; display:flex; align-items:center; justify-content:space-between; gap:0.75rem;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
              <div id="prof-role-icon-wrap"></div>
              <div>
                <strong id="prof-role-title" style="font-size:0.86rem; color:#0F172A; display:block;">Akun Pengguna</strong>
                <small id="prof-role-email" style="color:#64748B; font-size:0.75rem;"></small>
              </div>
            </div>
            <div>
              <span id="prof-role-badge" style="font-size:0.75rem; font-weight:800; padding:0.25rem 0.65rem; border-radius:9999px; border:1px solid #E2E8F0;">
                Akun Aktif
              </span>
            </div>
          </div>

          <form id="form-sij-profile" onsubmit="saveProfileModal(event)">
            
            <!-- Foto Profil Resmi Siswa -->
            <div class="sij-pasfoto-wrapper">
              <div class="sij-pasfoto-box" id="profile-avatar-display-box">
                ${renderAvatarHtml(currentUser ? currentUser.avatar : '', currentUser ? currentUser.name : '', 'profile-modal-avatar-img')}
              </div>
              <div class="sij-pasfoto-badge-row">
                <span>Foto Profil Akun:</span>
                <span class="sij-badge-foto-kustom">Foto Identitas</span>
              </div>
              <div class="sij-pasfoto-buttons">
                <input type="file" id="modal-photo-input" accept="image/jpeg,image/png,image/webp,image/jpg" style="display:none;" onchange="handleModalPhotoSelected(event)" />
                <button type="button" class="btn-pasfoto-upload" onclick="triggerProfilePhotoUpload()" style="background:#2563EB; color:#fff; border:none;">
                  <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                  <span>Upload Foto</span>
                </button>
                <button type="button" class="btn-pasfoto-anonim" onclick="setAnonymousAvatar()">
                  <span>Foto Anonim</span>
                </button>
              </div>
            </div>

            <!-- Form Data Peserta -->
            <div class="sij-form-group">
              <label for="prof-nama">Nama Lengkap Siswa:</label>
              <input type="text" id="prof-nama" class="sij-form-input" required />
            </div>

            <div class="sij-form-group">
              <label for="prof-reg">Nomor Induk Siswa / NISN:</label>
              <input type="text" id="prof-reg" class="sij-form-input" required />
            </div>

            <div class="sij-form-row">
              <div class="sij-form-group">
                <label for="prof-class">Kelas / Rombel:</label>
                <select id="prof-class" class="sij-form-input sij-form-select">
                  <option value="Kelas X-A">Kelas X-A</option>
                  <option value="Kelas X-B">Kelas X-B</option>
                  <option value="Kelas XI-A">Kelas XI-A</option>
                  <option value="Kelas XI-B">Kelas XI-B</option>
                  <option value="Kelas XII">Kelas XII</option>
                  <option value="Siswa Umum">Siswa Umum / Mandiri</option>
                  <option value="Guru">Guru</option>
                </select>
              </div>
              <div class="sij-form-group">
                <label for="prof-gender">Jenis Kelamin:</label>
                <select id="prof-gender" class="sij-form-input sij-form-select">
                  <option value="Laki-laki (MALE)">Laki-laki (MALE)</option>
                  <option value="Perempuan (FEMALE)">Perempuan (FEMALE)</option>
                </select>
              </div>
            </div>

            <!-- Akses Guru jika akun guru -->
            <div id="guru-shortcut-area" style="display:none;" class="guru-access-box">
              <div>
                <strong style="color:#B91C1C; font-size:0.86rem; display:block;">Hak Akses Guru Pengajar</strong>
                <small style="color:#64748B;">Kelola modul pelajaran, bank soal &amp; rapor siswa</small>
              </div>
              <a href="${guruUrl}" class="btn-open-guru-dash">Buka Dashboard Guru &rarr;</a>
            </div>

            <button type="submit" class="btn-sij-save-profile">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
              <span>Simpan Perubahan Data Profil</span>
            </button>
          </form>

          <div class="modal-actions-row" style="justify-content:center; padding-top:0.75rem;">
            <button type="button" class="btn-modal-logout" onclick="logoutFromModal()" style="width:100%; justify-content:center; padding:0.7rem 1rem; border-radius:12px; background:#FEF2F2; border:1px solid #FECACA;">
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
              <span>Keluar dari Akun (Logout)</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  `;

  document.body.insertAdjacentHTML('beforeend', modalHtml);
}

// ====================================================
// LOGIKA MODAL PROFIL (PAS MENCET BUBBLE)
// ====================================================
const AVATAR_PRESETS = [
  'img/avatar_default.svg',
  'img/avatar_anggata.svg',
  'img/avatar_aoi.svg',
  'img/avatar_tanaka.svg'
];
let currentAvatarIdx = 0;

function triggerProfilePhotoUpload() {
  const input = document.getElementById('modal-photo-input');
  if (input) input.click();
}

function handleModalPhotoSelected(event) {
  const file = event.target.files && event.target.files[0];
  if (!file) return;

  if (!file.type.startsWith('image/')) {
    alert('Silakan pilih file foto gambar (JPG, PNG, atau WebP).');
    return;
  }

  if (file.size > 3 * 1024 * 1024) {
    alert('Ukuran file foto maksimal 3MB.');
    return;
  }

  const reader = new FileReader();
  reader.onload = function(e) {
    const dataUrl = e.target.result;
    if (currentUser) {
      currentUser.avatar = dataUrl;
    }
    const avatarBox = document.getElementById('profile-avatar-display-box');
    if (avatarBox) {
      avatarBox.innerHTML = renderAvatarHtml(dataUrl, currentUser ? currentUser.name : '', 'profile-modal-avatar-img');
    }
  };
  reader.readAsDataURL(file);
}

function openProfileModal() {
  if (!currentUser) {
    goToLogin();
    return;
  }
  const modal = document.getElementById('modal-user-profile');
  if (!modal) return;

  const isGuru = currentUser.role === 'guru';

  document.getElementById('prof-nama').value = currentUser.name || '';
  document.getElementById('prof-reg').value = currentUser.reg_no || (isGuru ? 'SIJ-2026-GURU01' : 'JFT-2026-51720');
  document.getElementById('prof-gender').value = currentUser.gender || 'Laki-laki (MALE)';
  
  const classField = document.getElementById('prof-class');
  if (classField) {
    const targetClass = currentUser.class_room || (isGuru ? 'Guru' : 'Kelas X-A');
    let exists = false;
    for (let i = 0; i < classField.options.length; i++) {
      if (classField.options[i].value === targetClass) {
        exists = true;
        break;
      }
    }
    if (!exists) {
      const opt = document.createElement('option');
      opt.value = targetClass;
      opt.textContent = targetClass;
      classField.appendChild(opt);
    }
    classField.value = targetClass;
  }

  const avatarBox = document.getElementById('profile-avatar-display-box');
  if (avatarBox) {
    avatarBox.innerHTML = renderAvatarHtml(currentUser.avatar, currentUser.name, 'profile-modal-avatar-img');
  }

  const roleIconWrap = document.getElementById('prof-role-icon-wrap');
  const roleTitle = document.getElementById('prof-role-title');
  const roleEmail = document.getElementById('prof-role-email');
  const roleBadge = document.getElementById('prof-role-badge');

  if (roleIconWrap) {
    roleIconWrap.innerHTML = renderAvatarHtml(currentUser.avatar, currentUser.name, 'prof-role-avatar-thumb');
  }
  if (roleTitle) roleTitle.textContent = isGuru ? 'Guru Pengajar (Master)' : 'Siswa Belajar';
  if (roleEmail) roleEmail.textContent = currentUser.email || '';
  if (roleBadge) {
    roleBadge.textContent = isGuru ? 'Guru' : 'Siswa Aktif';
    roleBadge.style.background = isGuru ? '#FEF2F2' : '#EFF6FF';
    roleBadge.style.color = isGuru ? '#D9383A' : '#2563EB';
    roleBadge.style.borderColor = isGuru ? '#FECACA' : '#BFDBFE';
  }

  const guruBox = document.getElementById('guru-shortcut-area');
  if (guruBox) {
    guruBox.style.display = isGuru ? 'flex' : 'none';
  }

  modal.classList.add('show');
}

function closeProfileModal() {
  const modal = document.getElementById('modal-user-profile');
  if (!modal) return;
  modal.classList.remove('show');
}

function pickNextAvatar() {
  currentAvatarIdx = (currentAvatarIdx + 1) % AVATAR_PRESETS.length;
  const newAvatar = AVATAR_PRESETS[currentAvatarIdx];
  if (currentUser) {
    currentUser.avatar = newAvatar;
  }
  const avatarBox = document.getElementById('profile-avatar-display-box');
  if (avatarBox) {
    avatarBox.innerHTML = renderAvatarHtml(newAvatar, currentUser ? currentUser.name : '', 'profile-modal-avatar-img');
  }
}

function setAnonymousAvatar() {
  const defaultAvatar = 'img/avatar_default.svg';
  if (currentUser) {
    currentUser.avatar = defaultAvatar;
  }
  const avatarBox = document.getElementById('profile-avatar-display-box');
  if (avatarBox) {
    avatarBox.innerHTML = renderAvatarHtml(defaultAvatar, currentUser ? currentUser.name : '', 'profile-modal-avatar-img');
  }
}

async function saveProfileModal(e) {
  e.preventDefault();
  if (!currentUser) return;

  currentUser.name = document.getElementById('prof-nama').value.trim();
  currentUser.reg_no = document.getElementById('prof-reg').value.trim();
  currentUser.gender = document.getElementById('prof-gender').value;
  
  const classField = document.getElementById('prof-class');
  if (classField) {
    currentUser.class_room = classField.value.trim();
  }

  saveUser(currentUser);

  // Sync ke backend Laravel jika sesi terautentikasi
  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    await fetch('/api/auth/profile', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {})
      },
      body: JSON.stringify({
        name: currentUser.name,
        avatar: currentUser.avatar,
        gender: currentUser.gender,
        reg_no: currentUser.reg_no,
        class_room: currentUser.class_room
      })
    });
  } catch (err) {}

  closeProfileModal();
  await showLoadingOverlay('Menyimpan Profil...', 'Memperbarui data identitas peserta...', currentUser.avatar, 600);
  renderUserWidget();
}

function goToLogin() {
  window.location.href = resolveAuthUrl('login');
}

function openLoginModal() {
  goToLogin();
}

function closeLoginModal() {
  // Modal fallback
}

async function logoutFromModal() {
  closeProfileModal();
  await logoutUser();
}

async function logoutUser() {
  await showLoadingOverlay('Mengeluarkan Akun...', 'Membersihkan sesi login...', 'img/avatar_anggata.svg', 500);
  isUserLoggedIn = false;
  currentUser = null;
  try {
    localStorage.removeItem('sijapanese_active_user');
    localStorage.removeItem('sijapanese_auth_user');
    sessionStorage.clear();
  } catch (e) {}

  // Panggil API logout Laravel jika online
  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    await fetch('/api/auth/logout', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {})
      }
    });
  } catch (e) {}

  const laravelLogoutForm = document.getElementById('logout-form');
  if (laravelLogoutForm) {
    laravelLogoutForm.submit();
  } else {
    renderUserWidget();
    window.location.href = resolveAuthUrl('home');
  }
}

// ====================================================
// MODAL LOGIN & REGISTER DI HALAMAN UTAMA (INLINE)
// ====================================================
function openAuthModal(tab = 'login') {
  const modal = document.getElementById('auth-modal');
  if (modal) {
    switchAuthTab(tab);
    modal.classList.remove('hidden');
  } else {
    window.location.href = resolveAuthUrl(tab === 'register' ? 'register' : 'login');
  }
}

function closeAuthModal() {
  const modal = document.getElementById('auth-modal');
  if (modal) {
    modal.classList.add('hidden');
  }
}

function switchAuthTab(tab) {
  const tabLogin = document.getElementById('tab-btn-login');
  const tabReg = document.getElementById('tab-btn-register');
  const formLogin = document.getElementById('auth-login-form');
  const formReg = document.getElementById('auth-register-form');

  if (tab === 'login') {
    if (tabLogin) tabLogin.classList.add('active');
    if (tabReg) tabReg.classList.remove('active');
    if (formLogin) formLogin.style.display = 'block';
    if (formReg) formReg.style.display = 'none';
  } else {
    if (tabLogin) tabLogin.classList.remove('active');
    if (tabReg) tabReg.classList.add('active');
    if (formLogin) formLogin.style.display = 'none';
    if (formReg) formReg.style.display = 'block';
  }
}

async function loginDemo(role) {
  const isGuru = role === 'guru';
  const targetEmail = isGuru ? 'guru@sijapanese.sch.id' : 'kenji@sijapanese.sch.id';

  // 1. Coba via API Laravel
  try {
    const res = await fetch('/api/auth/demo', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ role: role })
    });
    const data = await res.json();
    if (data && data.success) {
      if (data.user) {
        saveUser(data.user);
        currentUser = data.user;
        isUserLoggedIn = true;
      }
      closeAuthModal();
      await showLoadingOverlay('Beralih Akun...', `Masuk sebagai ${data.user.name}...`, data.user.avatar, 600);
      window.location.href = data.redirect || resolveAuthUrl(isGuru ? 'guru' : 'home');
      return;
    }
  } catch (e) {}

  // 2. Client-side fallback
  const demoAccount = DEMO_ACCOUNTS[isGuru ? 'guru' : 'kenji'];
  saveUser(demoAccount);
  currentUser = demoAccount;
  isUserLoggedIn = true;
  closeAuthModal();
  await showLoadingOverlay('Beralih Akun...', `Masuk sebagai ${demoAccount.name}...`, demoAccount.avatar, 600);
  renderUserWidget();
  window.location.href = resolveAuthUrl(isGuru ? 'guru' : 'home');
}

async function handleLoginSubmit(e) {
  e.preventDefault();
  const form = e.target;
  const email = form.email.value.trim();
  const password = form.password.value.trim();
  const errBox = document.getElementById('auth-login-error');
  if (errBox) errBox.style.display = 'none';

  try {
    const res = await fetch('/api/auth/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ email, password })
    });
    const data = await res.json();
    if (data && data.success) {
      if (data.user) {
        saveUser(data.user);
        currentUser = data.user;
        isUserLoggedIn = true;
      }
      closeAuthModal();
      await showLoadingOverlay('Berhasil Masuk!', `Selamat datang, ${data.user.name}`, data.user.avatar, 600);
      window.location.href = data.redirect || resolveAuthUrl(data.user?.role === 'guru' ? 'guru' : 'home');
      return;
    } else {
      if (errBox) {
        errBox.textContent = data.message || 'Email atau kata sandi tidak cocok.';
        errBox.style.display = 'block';
      }
      return;
    }
  } catch (err) {
    // Local fallback
  }

  // Local storage check
  let registeredUsers = {};
  try {
    registeredUsers = JSON.parse(localStorage.getItem('sij_registered_users')) || {};
  } catch (e) {}

  const all = { ...DEMO_ACCOUNTS, ...registeredUsers };
  let found = Object.values(all).find(u => (u.email && u.email.toLowerCase() === email.toLowerCase()) || (u.reg_no && u.reg_no.toLowerCase() === email.toLowerCase()));
  if (!found) {
    if (errBox) {
      errBox.textContent = 'Akun tidak ditemukan. Silakan periksa kembali email/NISN atau buat akun baru di tab Daftar.';
      errBox.style.display = 'block';
    }
    return;
  }

  const validPassword = found.password || 'password';
  if (password !== validPassword) {
    if (errBox) {
      errBox.textContent = 'Kata sandi tidak sesuai. Silakan coba lagi.';
      errBox.style.display = 'block';
    }
    return;
  }

  saveUser(found);
  currentUser = found;
  isUserLoggedIn = true;
  closeAuthModal();
  await showLoadingOverlay('Berhasil Masuk!', `Selamat datang, ${found.name}`, found.avatar, 600);
  renderUserWidget();
  window.location.href = resolveAuthUrl(found.role === 'guru' ? 'guru' : 'home');
}

async function handleRegisterSubmit(e) {
  e.preventDefault();
  const form = e.target;
  const name = form.name.value.trim();
  const email = form.email.value.trim().toLowerCase();
  const avatar = form.avatar.value;
  const password = form.password.value;
  const errBox = document.getElementById('auth-register-error');
  if (errBox) errBox.style.display = 'none';

  if (!name || !email || !password) {
    if (errBox) {
      errBox.textContent = 'Semua kolom wajib diisi.';
      errBox.style.display = 'block';
    }
    return;
  }

  if (password.length < 6) {
    if (errBox) {
      errBox.textContent = 'Kata sandi minimal harus 6 karakter.';
      errBox.style.display = 'block';
    }
    return;
  }

  try {
    const res = await fetch('/api/auth/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ name, email, avatar, password, role: 'siswa' })
    });
    const data = await res.json();
    if (data && data.success) {
      if (data.user) {
        saveUser(data.user);
        currentUser = data.user;
        isUserLoggedIn = true;
      }
      closeAuthModal();
      await showLoadingOverlay('Akun Berhasil Dibuat!', `Selamat datang, ${data.user.name}`, data.user.avatar, 600);
      window.location.href = data.redirect || resolveAuthUrl('home');
      return;
    } else {
      if (errBox) {
        errBox.textContent = data.message || 'Pendaftaran tidak dapat diproses.';
        errBox.style.display = 'block';
      }
      return;
    }
  } catch (err) {}

  // Local fallback
  let registeredUsers = {};
  try {
    registeredUsers = JSON.parse(localStorage.getItem('sij_registered_users')) || {};
  } catch (err) {}

  if (Object.values(DEMO_ACCOUNTS).some(u => u.email.toLowerCase() === email) || registeredUsers[email]) {
    if (errBox) {
      errBox.textContent = 'Alamat email sudah terdaftar. Silakan masuk melalui tab Masuk.';
      errBox.style.display = 'block';
    }
    return;
  }

  const newUser = {
    name,
    email,
    password,
    role: 'siswa',
    avatar,
    score: 0,
    reg_no: 'JFT-2026-' + Math.floor(Math.random()*90000+10000),
    class_room: 'Kelas X'
  };

  registeredUsers[email] = newUser;
  localStorage.setItem('sij_registered_users', JSON.stringify(registeredUsers));
  saveUser(newUser);
  currentUser = newUser;
  isUserLoggedIn = true;
  closeAuthModal();
  await showLoadingOverlay('Akun Berhasil Dibuat!', `Selamat datang, ${newUser.name}`, newUser.avatar, 600);
  renderUserWidget();
  window.location.href = resolveAuthUrl('home');
}

function saveUser(user) {
  try {
    localStorage.setItem('sijapanese_active_user', JSON.stringify(user));
    localStorage.setItem('sijapanese_auth_user', JSON.stringify(user));
  } catch (e) {}
}

function handleBackdropClick(e, modalId) {
  if (e.target.id === modalId) {
    document.getElementById(modalId).classList.remove('show');
  }
}

window.addPointsToUser = function(points) {
  if (!points || !currentUser) return;
  currentUser.score = (currentUser.score || 0) + points;
  saveUser(currentUser);
  renderUserWidget();
};

function escapeHtml(text) {
  if (text === null || text === undefined) return '';
  const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
  return String(text).replace(/[&<>"']/g, function(m) {
    return map[m] || m;
  });
}

// Global expose
window.openAuthModal = openAuthModal;
window.closeAuthModal = closeAuthModal;
window.switchAuthTab = switchAuthTab;
window.loginDemo = loginDemo;
window.handleLoginSubmit = handleLoginSubmit;
window.handleRegisterSubmit = handleRegisterSubmit;
window.logoutUser = logoutUser;
window.openProfileModal = openProfileModal;
window.closeProfileModal = closeProfileModal;
