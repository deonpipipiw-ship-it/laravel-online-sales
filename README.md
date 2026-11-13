# Ruang Belanja - Aplikasi E-Commerce Laravel

Aplikasi penjualan online (*e-commerce*) berbasis **Laravel** dan **MySQL** dengan pemisahan peran **Admin** dan **Pelanggan (Customer)**, manajemen inventaris stok masuk/keluar, keranjang belanja berbasis session, checkout transaksional, serta validasi pesanan.

## Fitur Utama

### 1. Autentikasi & Otorisasi Multi-Role
- Registrasi pelanggan (`customer`) dan login berbasis session.
- Middleware `role:admin` dan `role:customer` untuk isolasi hak akses halaman.

### 2. Panel Administrasi (`Admin`)
- **Dashboard Ringkasan:** Total produk, peringatan stok menipis (`< 5`), pesanan `pending`, dan total penjualan hari ini.
- **Manajemen Kategori & Produk:** CRUD kategori (otomatis slug) serta CRUD produk lengkap dengan SKU unik, harga, status aktif, dan unggah foto produk.
- **Inventaris & Histori Stok:** Pencatatan barang masuk (`IN`) dan audit otomatis pergerakan stok keluar (`OUT`) saat checkout maupun pengembalian stok (`IN`) saat pesanan dibatalkan.
- **Layanan Ekspedisi:** Pengelolaan kurir, jenis layanan, estimasi waktu tiba, dan tarif ongkos kirim.
- **Validasi & Manajemen Transaksi:** Validasi pesanan (`pending` $\rightarrow$ `confirmed`), pembaruan status pengiriman bertahap (`processed` $\rightarrow$ `shipped` $\rightarrow$ `completed`), serta pembatalan pesanan dengan *rollback* stok otomatis.

### 3. Etalase Toko (`Customer`)
- **Katalog & Pencarian:** Filter berdasarkan nama/SKU, kategori, rentang harga, ketersediaan stok, pengurutan, dan *pagination*.
- **Detail Produk:** Halaman detail berbasis `slug`.
- **Keranjang Belanja:** Penyimpanan berbasis session dengan validasi batas stok tersedia.
- **Checkout & Riwayat Pesanan:** Perhitungan subtotal + ongkir otomatis, pembuatan kode pesanan unik, pengurangan stok secara atomik (`DB::transaction`), dan pemantauan status pesanan.

## Instalasi & Menjalankan Proyek

1. **Clone repositori dan masuk ke direktori proyek:**
   ```bash
   git clone [https://github.com/deonpipipiw-ship-it/laravel-online-sales.git](https://github.com/deonpipipiw-ship-it/laravel-online-sales.git)
   cd laravel-online-sales
   
