# Inventory Management System - Laravel Fundamental (Tugas Pertemuan 5)

Proyek ini merupakan hasil migrasi (*refactoring*) dari **Inventory Management System (Pertemuan 4)** berbasis PHP Native ke arsitektur **Laravel 11 MVC**.

---

## 1. Arsitektur MVC & Alur Permintaan (Request Lifecycle)
Aplikasi mengimplementasikan alur:
`Request → Route → Controller → Model → Database → Response`

1. **Request & Route (`routes/web.php`):**
   - Rute didefinisikan menggunakan metode standar RESTful (`Route::resource('products', ProductController::class)`) serta *named routes*.
   - Rute dilindungi oleh middleware `auth` untuk memastikan hanya pengguna yang sah yang dapat mengakses sistem.
2. **Controller (`app/Http/Controllers/`):**
   - `ProductController`: Mengatur validasi permintaan, pemanggilan relasi Eloquent, dan penyusunan pagination/filter.
   - `StockController`: Menjalankan logika bisnis *Barang Masuk* & *Barang Keluar* dengan `DB::transaction()` dan *pessimistic locking* (`lockForUpdate`).
   - `DashboardController`: Menghitung agregasi statistik inventaris.
3. **Model & Database (`app/Models/` & `database/migrations/`):**
   - Menggunakan Eloquent ORM: `Product`, `Category`, `Supplier`, `StockMovement`, dan `User`.
   - Relasi:
     - `Category` 1 — N `Product` (`hasMany` / `belongsTo`)
     - `Product` N — M `Supplier` (`belongsToMany` via tabel perantara `product_suppliers`)
     - `Product` 1 — N `StockMovement`
4. **View & Response (`resources/views/`):**
   - Tampilan menggunakan **Blade Templating** (`layouts/app.blade.php`), komponen reusable (`<x-alert>`), form CSRF protection (`@csrf`), dan *output escaping* otomatis (`{{ }}`) untuk mencegah kerentanan XSS.

---

## 2. Fitur Utama & Pemenuhan Kriteria Tugas P5
- [x] **Environment & Migration:** Dikelola dengan Composer, `.env`, dan skema migrasi database modular.
- [x] **Seeder & Factory:** Siap dijalankan dengan satu perintah `php artisan migrate:fresh --seed`.
- [x] **Resource Controller & Eloquent CRUD:** Operasi create, read, update, delete lengkap.
- [x] **Pencarian, Filter, Sorting, & Pagination:** Filter nama/SKU, kategori, dan pengurutan dinamis dengan parameter URL yang dipertahankan (`withQueryString()`).
- [x] **Proteksi Business Rules Persediaan:**
  - SKU produk harus unik.
  - Kuantitas dan harga tidak boleh negatif.
  - Transaksi barang keluar tidak boleh melebihi stok yang tersedia.
  - Produk yang memiliki catatan riwayat mutasi stok dilindungi dari penghapusan sembarangan.
  - Perubahan stok dan pencatatan audit mutasi dieksekusi secara atomik menggunakan transaksi database.

---

## 3. Panduan Instalasi & Menjalankan Proyek

1. **Ekstrak & Masuk ke Folder Proyek:**
   ```bash
   cd inventory-laravel
   ```

2. **Install Dependensi PHP (Composer):**
   ```bash
   composer install
   ```

3. **Jalankan Migrasi & Data Uji (Seeder):**
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Jalankan Development Server:**
   ```bash
   php artisan serve
   ```
   Akses melalui browser di: `http://127.0.0.1:8000`

---

## 4. Kredensial Pengujian (Demo Akun)
- **Role Admin:**
  - Username: `admin`
  - Password: `admin123`
- **Role Staff:**
  - Username: `staff`
  - Password: `staff123`

---

## 5. Bukti Pengujian Alur Lengkap (Acceptance Criteria)
Alur: **Buka Form Tambah Produk → Validasi Error → Simpan Berhasil → Redirect → Muncul di Daftar Produk & Dashboard**
1. Akses menu **Produk** lalu klik **Tambah Produk Baru** (`/products/create`).
2. Masukkan input tidak valid (misal: harga bernilai minus atau SKU kosong) $
ightarrow$ Form otomatis menolak dengan pesan error validasi Blade.
3. Masukkan data valid $
ightarrow$ Klik Simpan.
4. Sistem otomatis menyimpan data ke tabel `products`, mengaitkan supplier ke `product_suppliers`, redirect ke halaman index dengan *flash message* sukses, dan data langsung terhitung pada total aset di **Dashboard**.
