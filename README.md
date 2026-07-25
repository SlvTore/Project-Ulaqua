# Ulaqua Integrated Application

Aplikasi Ulaqua merupakan hasil penggabungan dari dua repositori terpisah:
1. **Frontend Publik (React SPA):** Halaman profil perusahaan dan info produk untuk pelanggan umum.
2. **Inventory Management System (IMS) (Laravel Monolith):** Sistem manajemen inventaris internal dengan kontrol akses berbasis peran (RBAC) untuk staf.

Kedua aplikasi ini sekarang berjalan di bawah arsitektur **Hybrid Single Server** menggunakan Laravel sebagai server utama yang menyajikan aset kompilasi React untuk publik dan melayani dashboard internal untuk staf.

---

## Struktur Folder Utama

*   **`frontend/`**: Berkas sumber React (Vite, React Router, CSS).
*   **`public/`**: Folder aset publik Laravel yang juga menjadi tujuan build dari frontend React.
*   **`routes/web.php`**: Rute web utama, termasuk prefix `/admin` untuk IMS dan fallback route untuk menyajikan React SPA.
*   **`routes/api.php`**: Rute API publik (untuk daftar produk dan pencatatan analitik).
*   **`app/Http/Controllers/Api/PublicItemController.php`**: Controller API publik untuk melayani data produk dan melacak kunjungan produk.

---

## Langkah Instalasi & Persiapan

### 1. Persiapan Backend Laravel
1. Salin berkas `.env.example` menjadi `.env` (jika belum ada).
2. Jalankan perintah instalasi dependensi PHP:
   ```bash
   composer install
   ```
3. Generate application key:
   ```bash
   php artisan key:generate
   ```
4. Konfigurasikan koneksi database Anda di dalam berkas `.env`.
5. Jalankan migrasi database dan pengisian data awal (seeder):
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

### 2. Persiapan Frontend React
1. Masuk ke direktori `frontend/`:
   ```bash
   cd frontend
   ```
2. Jalankan instalasi dependensi Node.js:
   ```bash
   npm install
   ```
3. Lakukan build kompilasi aset untuk menyalin halaman publik ke folder `public/` Laravel:
   ```bash
   npm run build
   ```

---

## Cara Menjalankan Aplikasi

Jalankan server lokal Laravel melalui terminal:
```bash
php artisan serve
```
Akses aplikasi melalui browser:
*   **Halaman Publik (React):** [http://localhost:8000](http://localhost:8000)
*   **Halaman Login Admin (IMS):** [http://localhost:8000/admin/login](http://localhost:8000/admin/login)

---

## Autentikasi & Hak Akses (RBAC)

1. **Akses Publik:** Seluruh halaman company profile, daftar produk, dan informasi layanan dapat diakses tanpa login.
2. **Akses Admin / Staf:** Seluruh fitur internal IMS berada di bawah prefix rute `/admin` dan dilindungi oleh middleware autentikasi.
3. **Akun Uji Coba Default:**
   *   **Email:** `admin@ulaqua.local`
   *   **Sandi:** `password123`
   *   **Peran:** Manager (Akses Penuh IMS)

---

## Fitur Analitik Produk Terintegrasi

*   **Pencatatan Klik:** Ketika pelanggan mengklik judul produk atau tombol "Pesan Sekarang" di halaman depan publik, aplikasi React akan secara otomatis mengirimkan permintaan ke API `POST /api/public/items/{id}/view` untuk mencatat ketertarikan pelanggan.
*   **Checkout Langsung WhatsApp:** Tombol "Pesan Sekarang" akan mengarahkan pelanggan langsung ke WhatsApp resmi Ulaqua dengan pesan pesanan yang terisi otomatis.
*   **Dashboard Analitik:** Staf admin dapat melihat visualisasi data real-time berupa tabel produk terpopuler berdasarkan kunjungan di bagian bawah dashboard admin IMS untuk membantu keputusan manajemen stok.

---

## Menjalankan Pengujian Otomatis

Aplikasi ini dilengkapi pengujian otomatis untuk memverifikasi kebijakan proteksi rute. Jalankan perintah berikut:
```bash
php artisan test
```
