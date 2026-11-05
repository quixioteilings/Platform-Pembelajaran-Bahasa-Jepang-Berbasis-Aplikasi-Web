# SIJapanese

Platform pembelajaran bahasa Jepang interaktif berbasis aplikasi web yang dirancang untuk membantu peserta didik menguasai aksara, kosakata, tata bahasa dasar, dan percakapan situasional secara bertahap dan terstruktur.

Aplikasi ini menggabungkan materi kurikulum berstandar JLPT N5 dan N4 dengan gamifikasi edukatif, sistem audio pelafalan asli, serta dashboard khusus guru untuk memantau perkembangan dan nilai latihan siswa.

---

## Fitur Utama

### 1. Kurikulum dan Materi Terstruktur
* **Aksara Hiragana**: 104 huruf lengkap (huruf dasar, tenten, maru, dan gabungan/youon) disertai contoh kata, romaji toggle, dan audio pelafalan.
* **Aksara Katakana**: 104 huruf lengkap (huruf dasar, tenten, maru, dan gabungan/youon) dengan visualisasi stroke dan audio.
* **Kamus & Eksplorasi Kosakata**: Perbendaharaan kosakata praktis sehari-hari yang dikelompokkan berdasarkan kategori (kata ganti, angka, salam, kata kerja, kata sifat, wisata, restoran, dan keluarga).
* **Modul Percakapan Situasional**: Modul tematik liburan ke Jepang (konbini, memesan makanan di kedai ramen, petunjuk arah di stasiun, dan reservasi hotel).

### 2. Gamifikasi dan Evaluasi Interaktif
* **Flashcard Audio Interaktif**: Kartu belajar bolak-balik dengan kontrol pemutaran suara asli, penanda status hafalan, dan akumulasi poin belajar.
* **Latihan dan Kuis Kosakata**: Paket latihan pilihan ganda dengan format tebak arti, pembacaan kanji/kana, dan audio chokai berstandar KKM 70.
* **Mini Games Edukatif**: Berbagai mode latihan refleks hafalan termasuk Kana Blast (turret blaster), Flash Card, dan Speed Quiz.

### 3. Autentikasi dan Keamanan Hak Akses
* **Portal Siswa**: Peserta didik dapat mendaftarkan akun secara mandiri, memilih avatar karakter (Anggata / Aoi), menyelesaikan modul, dan memantau kemajuan belajar pribadi.
* **Dashboard Master Guru**: Akses terproteksi untuk tenaga pengajar (`/guru` atau `guru.html`) guna mengelola modul pembelajaran, mengawasi progres siswa, dan merekapitulasi penilaian latihan secara langsung.
* **Proteksi Pendaftaran**: Form pendaftaran publik dibatasi khusus untuk akun siswa guna mencegah murid mengakses atau memanipulasi dashboard guru.

---

## Arsitektur dan Teknologi

* **Backend Framework**: PHP 8.x dengan Laravel Framework
* **Database**: SQLite (default lokal) / MySQL
* **Frontend**: HTML5, Modern CSS3 (Grid & Flexbox responsif mobile-desktop), Vanilla JavaScript (ES6+)
* **Aset Grafis**: Scalable Vector Graphics (SVG murni, independen tanpa dependensi font icon eksternal)
* **Audio Engine**: Web Speech Synthesis API dan cache audio audio native pelafalan bahasa Jepang

Proyek ini mendukung dua skenario deployment:
1. **Mode Fullstack Laravel**: Menggunakan routing Laravel, controller, Blade view engine, dan REST API.
2. **Mode Frontend Portabel**: Menggunakan file statis (`index.html`, `login.html`, `register.html`, `guru.html`) yang dapat dijalankan langsung di bawah direktori web server Apache XAMPP tanpa build tools tambahan.

---

## Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan komputer Anda telah terpasang:
* Web Server (Apache via XAMPP)
* PHP versi 8.1 atau yang lebih baru
* Composer (Package Manager PHP)
* Web Browser modern (Google Chrome, Mozilla Firefox, atau Microsoft Edge)

---

## Petunjuk Instalasi dan Menjalankan Proyek

### Opsi A: Menjalankan Menggunakan Server Laravel

1. Buka terminal atau Command Prompt di direktori proyek:
   ```bash
   cd "C:\Program Files\xampp\htdocs\PlatformPembalajaranBahasaJepang"
   ```

2. Pasang dependensi pustaka PHP:
   ```bash
   composer install
   ```

3. Salin konfigurasi environment jika file `.env` belum tersedia:
   ```bash
   cp .env.example .env
   ```

4. Buat kunci aplikasi Laravel:
   ```bash
   php artisan key:generate
   ```

5. Jalankan migrasi dan seeder database awal:
   ```bash
   php artisan migrate --seed
   ```

6. Jalankan server lokal:
   ```bash
   php artisan serve
   ```

7. Buka browser dan akses alamat:
   ```text
   http://localhost:8000
   ```

---

### Opsi B: Menjalankan Langsung via XAMPP

1. Pastikan folder proyek berada di dalam direktori root server:
   ```text
   C:\xampp\htdocs\PlatformPembalajaranBahasaJepang
   ```
2. Nyalakan modul **Apache** melalui XAMPP Control Panel.
3. Buka browser dan navigasikan ke alamat:
   ```text
   http://localhost/PlatformPembalajaranBahasaJepang/index.html
   ```

---

## Kredensial Akun Bawaan

Aplikasi dilengkapi dengan akun default untuk pengujian:

### 1. Akun Master Guru (Pengajar / Administrator)
* **Alamat Email**: `guru@sijapanese.sch.id`
* **Kata Sandi**: `password`
* **Nama Pengguna**: Sensei Tanaka
* **Hak Akses**: Dashboard Master Guru (`/guru` atau `guru.html`)

### 2. Akun Siswa Belajar
* **Alamat Email**: `kenji@sijapanese.sch.id`
* **Kata Sandi**: `password`
* **Nama Pengguna**: Anggata Al Haadi Ramadhan
* **Nomor Induk / NISN**: `JFT-2026-51720`
* **Tingkat Belajar**: JLPT N5

*Pengguna baru dapat langsung mendaftarkan diri sebagai siswa melalui halaman Registrasi (`/register` atau `register.html`).*

---

## Struktur Direktori Utama

```text
PlatformPembalajaranBahasaJepang/
├── app/
│   ├── Http/Controllers/    # Controller autentikasi, guru, dan evaluasi
│   └── Models/              # Model Eloquent (User, StudentAssessment, dll.)
├── database/
│   ├── migrations/          # Migrasi struktur tabel database
│   ├── seeders/             # Data awal modul, kuis, dan akun pengguna
│   └── database.sqlite      # Basis data lokal aplikasi
├── public/
│   ├── css/                 # Berkas stylesheet antarmuka publik
│   ├── js/                  # Skrip logika aplikasi dan autentikasi
│   └── img/                 # Aset vektor SVG karakter dan ilustrasi
├── resources/
│   └── views/               # Templat antarmuka berbasis Laravel Blade
├── index.html               # Halaman utama aplikasi (mode portabel)
├── login.html               # Halaman masuk sistem
├── register.html            # Halaman pendaftaran siswa baru
├── guru.html                # Panel kontrol dashboard master guru
├── AKUN_LOGIN.md            # Dokumentasi kredensial pengguna
└── GEMINI.md                # Panduan alur kerja dan aturan Git branch
```

---

## Lisensi dan Penggunaan

Proyek ini dikembangkan untuk kebutuhan media edukasi dan platform evaluasi pembelajaran bahasa Jepang di lingkungan sekolah dan pembelajaran mandiri.
