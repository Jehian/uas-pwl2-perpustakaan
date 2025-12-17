# 📚 Sistem Informasi Perpustakaan Digital

Aplikasi manajemen perpustakaan berbasis web yang modern dan responsif, dibangun menggunakan framework **Laravel**. Aplikasi ini menangani sirkulasi buku, manajemen anggota, stok buku, perhitungan denda otomatis, serta dilengkapi dengan katalog publik.

## ✨ Fitur Utama

### 🌍 Halaman Publik (Pengunjung)

* **Katalog Buku:** Tampilan grid buku dengan cover, judul, penulis, dan kategori.
* **Pencarian Real-time:** Cari buku berdasarkan Judul, Penulis, atau Kategori.
* **Cek Ketersediaan:** Indikator stok otomatis (Hijau = Tersedia, Merah = Habis).
* **Detail Pop-up:** Melihat sinopsis dan detail lengkap tanpa reload halaman.

### 🛡️ Panel Admin

* **Dashboard:** Ringkasan statistik perpustakaan.
* **Manajemen Buku:**

  * CRUD Buku (Judul, ISBN, Penerbit, Tahun, Cover).
  * Manajemen Stok (Eksemplar) per buku.
* **Manajemen Anggota:**

  * Registrasi anggota baru (Otomatis kirim Email Selamat Datang).
  * Edit & Non-aktifkan anggota.
* **Sirkulasi (Peminjaman & Pengembalian):**

  * Transaksi peminjaman buku.
  * Pengembalian dengan kalkulasi **Denda Keterlambatan** otomatis.
  * Validasi stok (Tidak bisa pinjam jika stok habis).
* **Notifikasi & UI:**

  * Konfirmasi hapus/aksi menggunakan **SweetAlert2**.
  * Feedback pesan sukses/error yang interaktif.

### 🤖 Otomatisasi

* **Email Reminder:** Sistem otomatis mengirim email pengingat H-1 sebelum jatuh tempo kepada peminjam via Scheduler.

---

## ⚙️ Persyaratan Sistem (Requirements)

* PHP >= 8.1
* Composer
* MySQL / MariaDB
* Node.js & NPM
* Git

---

## 🚀 Panduan Instalasi (Langkah demi Langkah)

### 1. Clone Repository

```bash
git clone https://github.com/username-anda/nama-repo-perpustakaan.git
cd nama-repo-perpustakaan
```

### 2. Install Dependencies

Install library backend (Laravel) dan frontend (Bootstrap/Vite).

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

Salin file konfigurasi contoh:

```bash
cp .env.example .env
```

Buka file `.env` dan sesuaikan konfigurasi berikut:

#### Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpustakaan
DB_USERNAME=root
DB_PASSWORD=
```

> Pastikan database `db_perpustakaan` sudah dibuat di phpMyAdmin atau MySQL.

#### Email (Wajib untuk fitur Notifikasi)

Gunakan SMTP Gmail (gunakan **App Password**, bukan password login biasa).

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email_anda@gmail.com
MAIL_PASSWORD=app_password_anda
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@perpustakaan.com"
MAIL_FROM_NAME="Perpustakaan Digital"
```

### 4. Setup Aplikasi

Jalankan perintah berikut secara berurutan:

```bash
# Generate key aplikasi
php artisan key:generate

# Migrasi tabel ke database
php artisan migrate

# Link folder storage (PENTING: agar gambar cover bisa muncul)
php artisan storage:link

# Build aset frontend
npm run build
```

---

## 👤 Membuat Akun Admin

Karena halaman registrasi publik dimatikan demi keamanan, buat akun Admin pertama melalui terminal.

Jalankan Tinker:

```bash
php artisan tinker
```

Copy-paste kode berikut ke dalam terminal Tinker:

```php
$user = new App\Models\User();
$user->name = 'Administrator';
$user->email = 'admin@perpustakaan.com';
$user->password = bcrypt('password123');
$user->save();
exit;
```

Login dengan:

* **Email:** [admin@perpustakaan.com](mailto:admin@perpustakaan.com)
* **Password:** password123

---

## 🏃‍♂️ Cara Menjalankan Aplikasi

### 1. Jalankan Server Web

```bash
php artisan serve
```

Buka browser di: `http://127.0.0.1:8000`

### 2. Jalankan Scheduler (Email Otomatis)

Agar pengingat H-1 berjalan, buka terminal baru dan jalankan:

```bash
php artisan schedule:work
```

---

## 📖 Panduan Penggunaan Singkat

* **Login Admin:** Masuk ke `/login` menggunakan akun admin.

### Tambah Data Master

1. Buat **Kategori Buku** terlebih dahulu.
2. Buat **Buku Induk**, upload cover, lalu isi deskripsi.
3. Masuk ke detail buku, klik **Kelola Stok** untuk menambah jumlah copy.

### Tambah Anggota

* Daftarkan member baru.
* Pastikan email member valid agar menerima notifikasi.

### Transaksi

* Masuk menu **Peminjaman**.
* Pilih Member dan Buku.
* Untuk pengembalian, klik tombol **Ceklis (Selesai)**. Denda akan muncul jika terlambat.

---

## ❓ Troubleshooting

* **Gambar Cover Tidak Muncul**

  * Pastikan sudah menjalankan `php artisan storage:link`.
  * Jika masih bermasalah, hapus folder `public/storage` lalu jalankan ulang perintah tersebut.

* **Email Error / Gagal Kirim**

  * Pastikan koneksi internet stabil.
  * Periksa konfigurasi `MAIL_` di `.env`.
  * Jika menggunakan Gmail, aktifkan 2-Step Verification dan gunakan **App Password**.


Dibuat untuk keperluan manajemen perpustakaan.
