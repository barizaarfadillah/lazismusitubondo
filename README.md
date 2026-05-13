# Sistem Informasi Lazismu Situbondo 🏢☀️

Sistem Informasi Filantropi berbasis web yang dirancang untuk mempermudah pengelolaan donasi, transparansi laporan keuangan, dan penyebaran kabar berita pada lembaga Lazismu Situbondo.

---

## 🚀 Fitur Utama

### 👨‍💼 Panel Admin (Back-Office)
- **Dashboard Analitik:** Ringkasan statistik donasi, grafik tahunan (Chart.js), dan notifikasi program mendesak.
- **Verifikasi Donasi:** Validasi bukti transfer donatur secara real-time.
- **Integrasi WhatsApp:** Pengiriman kuitansi otomatis beserta doa untuk donatur langsung ke WhatsApp.
- **Manajemen Artikel:** CMS lengkap untuk mengelola berita dan edukasi zakat/infak.
- **Laporan Keuangan:** Filter laporan multi-kriteria dan fitur cetak PDF resmi.
- **Manajemen Pengguna:** Pengaturan akun Admin dan Donatur dengan sistem proteksi keamanan.

### 👤 Fitur Donatur & Publik
- **Katalog Donasi:** Daftar program donasi aktif dengan bar progres pencapaian dana.
- **Dashboard Donatur:** Pantau riwayat donasi pribadi dan total kontribusi.
- **Landing Page Dinamis:** Menampilkan statistik transparan dan artikel terbaru.
- **Sistem Registrasi & Login:** Keamanan akun menggunakan middleware Laravel.

---

## 🛠️ Teknologi yang Digunakan

- **Framework:** [Laravel 11.x](https://laravel.com)
- **Database:** MySQL
- **Frontend:** Tailwind CSS & Vanilla JavaScript
- **Editor:** CKEditor 5 (Manajemen Konten)
- **Charts:** Chart.js
- **Icons:** FontAwesome 6

---

## ⚙️ Instalasi Lokal

Jika Anda ingin menjalankan proyek ini di lingkungan lokal (seperti Laragon/XAMPP), ikuti langkah berikut:

1. **Clone repositori:**
   ```bash
   git clone https://github.com/username/lazismu-situbondo.git
   ```

2. **Instal dependensi PHP:**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment:**
   Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda.
   ```bash
   cp .env.example .env
   ```

4. **Generate App Key:**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database:**
   ```bash
   php artisan migrate --seed
   ```

6. **Link Storage (Penting untuk Gambar):**
   ```bash
   php artisan storage:link
   ```

7. **Jalankan Server:**
   ```bash
   php artisan serve
   ```

---

## 📄 Lisensi

Sistem ini dikembangkan untuk keperluan **Lazismu Situbondo**. Hak cipta kode program diatur sesuai kesepakatan pengembang dan lembaga.

---

**Developed with ❤️ by [BARIZA ARFADILLAH ABQARIY](https://github.com/username)**