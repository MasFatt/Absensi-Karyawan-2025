
# 💼 Sistem Absensi & Penggajian Karyawan (Laravel 12)

Selamat datang di Sistem Absensi & HRIS — aplikasi web terintegrasi yang dibangun sepenuhnya menggunakan Laravel 12 sebagai studi kasus nyata untuk penerapan arsitektur yang bersih, aman, dan profesional.

Dirancang untuk menyederhanakan manajemen SDM, aplikasi ini mencakup fitur lengkap: absensi harian dengan validasi canggih, alur persetujuan cuti dan lembur, hingga perhitungan gaji otomatis lengkap dengan export PDF. Semua dibungkus dalam antarmuka modern dan responsif berkat Tailwind CSS.

## ✨ Kutipan
> “Ilmu bukan milikku semua berasal dari-Nya. Jika ada yang tampak sebagai pengetahuan dariku, itu hanya bias Cahaya-Nya yang memantul pada cermin hati yang dikehendaki-Nya.”


## ✨ Fitur Utama
Sistem ini dilengkapi dengan serangkaian fitur komprehensif untuk manajemen karyawan:

### 👤 Autentikasi Multi-Role
Sistem login yang aman dengan tiga tingkat akses berbeda:
- **Admin**: Memiliki akses penuh ke seluruh sistem
- **Atasan**: Dapat menyetujui/menolak pengajuan lembur dan cuti
- **Karyawan**: Dapat melakukan absensi dan mengajukan lembur/cuti

### ✅ Absensi Real-time
- Validasi QR Code unik yang berubah setiap hari
- Validasi GPS & Radius lokasi kantor

### 🕒 Manajemen Lembur & Cuti
- Alur pengajuan dari Karyawan ke Atasan
- Fitur persetujuan (Approve/Reject) dengan catatan
- Upload dokumen bukti

### 💰 Penggajian Otomatis
- Perhitungan gaji berdasarkan kehadiran dan jam lembur
- Cetak Slip Gaji dalam format PDF

### 📊 Pelaporan & Audit
- Laporan Absensi Bulanan
- Audit Log aktivitas sistem

### ⚙️ Pengaturan Sistem Dinamis
- Konfigurasi jam kerja, lokasi kantor, radius absensi

## 🛠️ Teknologi yang Digunakan
| Komponen       | Teknologi                              |
|----------------|----------------------------------------|
| Backend        | PHP 8.2, Laravel 12                    |
| Frontend       | Blade, Tailwind CSS, Alpine.js         |
| Database       | MySQL / MariaDB                        |
| Server Lokal   | XAMPP                                  |
| Library Utama  | laravel/breeze, barryvdh/laravel-dompdf|

## 📋 Spesifikasi Sistem
- PHP versi 8.2+
- Composer 2
- Node.js & NPM
- Web Server (XAMPP recommended)
- Database Server (MySQL/MariaDB)

## 🚀 Panduan Instalasi
Ikuti langkah-langkah ini untuk menjalankan proyek di komputer lokal:

### 1. Clone Repositori
```bash
git clone https://github.com/MasFatt/Absensi-Karyawan-2025.git
cd sistem_cuti_karyawan
```

### 2. Instal Dependensi
```bash
composer install
npm install
```

### 3. Konfigurasi Lingkungan (.env)
```bash
copy .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Atur di file `.env`:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_sistem_absensi
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi & Seeding Database
```bash
php artisan migrate:fresh --seed
```

### 6. Buat Storage Link
```bash
php artisan storage:link
```

### 7. Jalankan Aplikasi
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Akses aplikasi di: http://localhost:8000

## 📁 Struktur Folder & File
```
sistem-absensi/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/       # Controller untuk admin
│   │   │   ├── Atasan/      # Controller untuk atasan
│   │   │   └── Karyawan/    # Controller untuk karyawan
│   ├── Models/              # Model database
│   └── Observers/           # Model observers
├── database/
│   ├── migrations/          # Skema database
│   └── seeders/             # Data awal
└── resources/
    └── views/               # Tampilan Blade
```

## 📣 Panduan Kontribusi
### Melalui Fork (Untuk Non-Kolaborator)
1. Fork repositori
2. Clone fork Anda:
   ```bash
   git clone https://github.com/NAMA_ANDA/Absensi-Karyawan-2025.git
   ```
3. Buat branch baru:
   ```bash
   git checkout -b fitur/nama-fitur-baru
   ```
4. Lakukan perubahan, commit, dan push
5. Buat Pull Request

### Sebagai Kolaborator
1. Clone repositori asli
2. Buat branch baru
3. Lakukan perubahan dan push
4. Buat Pull Request

## ✅ Pedoman Kontribusi
1. Gunakan standar PSR-12 dan ikuti gaya penulisan kode Laravel
2. Terapkan format Conventional Commits untuk setiap pesan commit
3. Pastikan setiap Pull Request hanya mencakup satu fitur atau perbaikan

🙏 Terima kasih atas kontribusinya — kualitas kode kita dimulai dari kamu!