<?php
// Memanggil file koneksi.php untuk menghubungkan aplikasi dengan database MySQL
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Menentukan judul halaman web yang tampil pada tab browser -->
    <title>Sistem Penjualan - Dashboard</title>
    <style>
        /* Pengaturan dasar untuk mereset margin, padding, dan teknik box-sizing seluruh elemen */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        /* Pengaturan gaya untuk keseluruhan tubuh halaman web */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        /* Styling untuk bagian bar navigasi (header atas) */
        .navbar {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        /* Kotak pembungkus utama konten halaman agar berada di tengah dengan lebar maksimal */
        .container {
            max-width: 900px;
            margin: 60px auto;
            padding: 0 20px;
            width: 100%;
        }
        /* Styling bagian teks sambutan/selamat datang */
        .welcome-title {
            text-align: center;
            margin-bottom: 40px;
        }
        .welcome-title h2 {
            color: #2c3e50;
            font-size: 26px;
            margin-bottom: 10px;
        }
        .welcome-title p {
            color: #7f8c8d;
            font-size: 15px;
        }
        /* Pengaturan tata letak (grid) untuk menu navigasi berbentuk kotak kartu */
        .menu-grid {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        /* Styling individual kartu menu */
        .card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px 20px;
            width: 260px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            border: 2px solid transparent;
        }
        /* Efek interaktif saat kursor diarahkan ke kartu menu (hover) */
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.15);
            border-color: #3498db;
        }
        /* Styling ikon emoji di dalam kartu menu */
        .card-icon {
            font-size: 45px;
            margin-bottom: 15px;
            display: block;
        }
        /* Styling judul menu di dalam kartu */
        .card-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        /* Styling deskripsi singkat menu di dalam kartu */
        .card-desc {
            font-size: 13px;
            color: #7f8c8d;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <!-- Bagian Header / Judul Utama Aplikasi di Bagian Atas -->
    <div class="navbar">
        <h1>SISTEM PENJUALAN</h1>
    </div>

    <!-- Kontainer Utama Dashboard -->
    <div class="container">
        <!-- Bagian Sambutan Pengguna -->
        <div class="welcome-title">
            <h2>Selamat Datang Di Toko Fenty</h2>
            <p>Silakan pilih menu di bawah untuk mengelola sistem penjualan</p>
        </div>

        <!-- Bagian Pilihan Menu Navigasi Utama -->
        <div class="menu-grid">
            <!-- Menu 1: Tautan menuju halaman Input Data Barang -->
            <a href="inputdata.php" class="card">
                <span class="card-icon">📝</span>
                <div class="card-title">Input Data Barang</div>
                <div class="card-desc">Halaman khusus untuk mengisi dan menambah produk baru</div>
            </a>

            <!-- Menu 2: Tautan menuju halaman Data Barang -->
            <a href="databarang.php" class="card">
                <span class="card-icon">📦</span>
                <div class="card-title">Data Barang</div>
                <div class="card-desc">Halaman khusus untuk melihat, mengubah, atau menghapus stok barang</div>
            </a>

            <!-- Menu 3: Tautan menuju halaman Form Penjualan -->
            <a href="transaksi.php" class="card">
                <span class="card-icon">🛒</span>
                <div class="card-title">Form Penjualan</div>
                <div class="card-desc">Halaman khusus untuk melakukan transaksi dan pembelian barang</div>
            </a>
        </div>
    </div>

</body>
</html>