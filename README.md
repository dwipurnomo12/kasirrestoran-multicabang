<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Aplikasi Kasir Restoran Multi Cabang


Sistem informasi BKK (Bursa Kerja Khusus) adalah sebuah sistem informasi yang dibangun untuk membantu proses perekrutan dan penempatan tenaga kerja di Indonesia. BKK sendiri adalah sebuah lembaga yang memiliki tugas untuk membantu memfasilitasi penempatan tenaga kerja di perusahaan-perusahaan yang membutuhkan.



# Fitur
Aplikasi Kasir Restoran Multi Cabang Berbasis Web dibuat dengan Framework Laravel, Javascript, Jquery Ajax. Terdapat 4 role yaitu Administrator, Kepala Restoran, Admin per-cabang, Kasir-percabang.

1. Administrator
- Manajemen produk (makanan/minuman)
- Manajemen Cabang
- Menu Kasir
- Data Penjualan
- Laporan Penjualan (Print)
- Rekap Pemasukan (Print)
- Manajemen User/Pengguna
- Manajemen Role/Hak Akses


2. Kepala Restoran
- Manajemen produk (makanan/minuman)
- Manajemen Cabang
- Data Penjualan
- Laporan Penjualan (Print)
- Rekap Pemasukan  (Print)


3. Admin (Kelola per-cabang)
- Manajemen produk (makanan/minuman)
- Data Penjualan
- Laporan Penjualan (Print)
- Rekap Pemasukan  (Print)


4. Kasir (Kelola per-cabang)
- Menu Kasir
- Data Penjualan



## Teknologi

Sistem Informasi Inventory Gudang menggunakan beberapa Teknologi diantaranya :

- Laravel - The PHP Framework for Web Artisans
- JavaScript - JavaScript, often abbreviated as JS, is a programming language that is one of the core technologies of the World Wide Web, alongside HTML and CSS.
- Bootstrap - Bootstrap is a free and open-source CSS framework directed at responsive, mobile-first front-end web development. 



## Installasi

Lakukan Clone Project/Unduh manual .

Aktifkan Xampp Control Panel, lalu akses ke http://localhost/phpmyadmin/.

Buat database dengan nama 'kasirresto'.

Jika melakukan Clone Project, rename file .env.example dengan env dan hubungkan
database nya dengan mengisikan nama database, 'DB_DATABASE=kasirresto'.


Kemudian, Ketik pada terminal :
```sh
php artisan migrate
```

Lalu ketik juga

```sh
php artisan migrate:fresh --seed
```

Jalankan aplikasi 

```sh
php artisan serve
```

Akses Aplikasi di Web browser 
```sh
127.0.0.1:8000
```

Demo Login :
1. Administrator
    - email     : administrator@gmail.com
    - password  : 1234
2. Kepala Restoran
    - email     : kepalarestoran@gmail.com
    - password  : 1234
3. Admin cabang pusat
    - email     : mandono@gmail.com
    - password  : 1234
4. Kasir cabang pusat
    - email     : mujiyono@gmail.com
    - password  : 1234

Demo Video : https://youtu.be/Hg7LXFC9M6Y

