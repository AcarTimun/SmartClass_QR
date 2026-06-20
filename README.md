# SmartClass QR

SmartClass QR adalah sistem manajemen presensi perkuliahan modern berbasis QR Code yang memfasilitasi interaksi antara Admin, Dosen, dan Mahasiswa. Aplikasi ini dikembangkan menggunakan **Laravel** dan **Tailwind CSS**.

## Fitur Utama

- **Role Management**: Terbagi menjadi 3 role (Admin, Dosen, Mahasiswa).
- **Auto-Generate Sesi**: Otomatis membuat 16 sesi presensi (14 pertemuan, UTS, UAS) ketika Jadwal Kuliah dibuat.
- **QR Code Scanner**: Dosen dapat membuka QR Code pada sesi yang aktif dan mahasiswa dapat memindai QR Code untuk mengisi kehadiran secara instan.
- **Manajemen Absensi**: Dosen dan Admin dapat mengedit status kehadiran mahasiswa secara manual, merekap absensi, serta menutup sesi (mengubah status seluruh mahasiswa yang belum absen menjadi "Tidak Hadir").
- **Statistik & Rekap**: Dasbor dan halaman detail menyediakan perhitungan total kehadiran secara *real-time*.

## Persyaratan Sistem

Pastikan environment lokal Anda sudah terinstall komponen dasar berikut sebelum melakukan instalasi:
- PHP 8.5.7
- Git
- Composer
- Node.js & NPM
- MySQL / MariaDB

## Instruksi Instalasi Lokal

1. **Clone repositori**
   ```bash
   git clone https://github.com/AcarTimun/SmartClass_QR.git
   cd SmartClass_QR
   ```

2. **Install dependensi PHP dan Node**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Duplikat file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Atur koneksi database Anda di file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=smartclass_qr
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database & Seeding Data Dummy**
   Jalankan perintah berikut untuk membuat struktur tabel sekaligus mengisi data simulasi yang realistis:
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Build Asset (Vite/Tailwind)**
   ```bash
   npm run build
   # atau jika dalam mode development: npm run dev
   ```

7. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Aplikasi kini dapat diakses di `http://127.0.0.1:8000`.

## Akun Default untuk Login (Testing)

Proses _seeding_ otomatis membuat beberapa akun default dengan _password_ yang sama yaitu `12345678`:

- **Admin**: `admin@mail.com`
- **Dosen**: Tersedia 10 dosen, contoh email `budi0@mail.com` (cek database tabel `users` untuk email lengkap).
- **Mahasiswa**: Tersedia 100 mahasiswa (NIM digunakan sebagai email), contoh email `240030000@mail.com`.

Seluruh _password_ untuk login adalah `12345678`.

---
*Dibuat untuk keperluan manajemen kelas dan kehadiran yang efisien.*
