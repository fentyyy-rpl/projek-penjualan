<?php
// 1. Menghubungkan file koneksi database agar bisa terhubung ke MySQL
include 'koneksi.php';

// 2. Mengecek apakah tombol dengan name 'simpan_transaksi' pada form telah diklik/disubmit
if (isset($_POST['simpan_transaksi'])) {
    
    // Mengambil data yang dikirimkan melalui form POST (nama pelanggan sekarang berupa teks biasa)
    $nama_pelanggan = mysqli_real_escape_string($conn, $_POST['nama_pelanggan']);
    $id_produk = $_POST['id_produk'];
    $jumlah_beli = $_POST['jumlah_beli'];

    // 3. Mengambil data produk berdasarkan ID produk yang dipilih dari database
    $q_produk = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
    $produk = mysqli_fetch_array($q_produk);
    
    // 4. Validasi: Cek apakah stok barang di database kurang dari jumlah yang dibeli
    if ($produk['stok'] < $jumlah_beli) {
        // Jika stok tidak cukup, tampilkan pesan peringatan pop-up JavaScript
        echo "<script>alert('Stok barang tidak mencukupi!');</script>";
    } else {
        // Jika stok cukup, ambil harga produk dan hitung total subtotal
        $harga = $produk['harga'];
        $subtotal = $harga * $jumlah_beli;

        // 5. Langkah 1: Menyimpan data transaksi utama ke tabel 'penjualan' 
        // (Menyimpan nama_pelanggan ke dalam kolom yang sesuai di database)
        $q_penjualan = mysqli_query($conn, "INSERT INTO penjualan (nama_pelanggan, total_harga) VALUES ('$nama_pelanggan', '$subtotal')");
        
        // Mengambil ID transaksi yang baru saja dibuat secara otomatis (auto increment)
        $id_penjualan_baru = mysqli_insert_id($conn);

        // 6. Langkah 2: Menyimpan detail pembelian ke tabel 'detail_penjualan'
        $q_detail = mysqli_query($conn, "INSERT INTO detail_penjualan (id_penjualan, id_produk, jumlah_beli, subtotal) VALUES ('$id_penjualan_baru', '$id_produk', '$jumlah_beli', '$subtotal')");

        // 7. Langkah 3: Mengurangi stok produk di tabel 'produk' secara otomatis
        $stok_sisa = $produk['stok'] - $jumlah_beli;
        mysqli_query($conn, "UPDATE produk SET stok = '$stok_sisa' WHERE id_produk = '$id_produk'");

        // 8. Mengecek apakah proses penyimpanan detail penjualan berhasil atau gagal
        if ($q_detail) {
            // Jika berhasil, tampilkan pesan sukses lalu arahkan halaman ke 'databarang.php'
            echo "<script>alert('Transaksi berhasil disimpan!'); window.location='databarang.php';</script>";
        } else {
            // Jika gagal
            echo "<script>alert('Gagal memproses transaksi!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penjualan</title>
    <style>
        /* Mengatur reset margin, padding, dan box-sizing untuk semua elemen */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        /* Mengatur tampilan latar belakang halaman dan posisi form agar berada di tengah layar */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        /* Styling kotak pembungkus (container) form */
        .form-container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 500px;
        }
        /* Styling judul di dalam form */
        .form-container h2 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 22px;
            text-align: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 12px;
        }
        /* Pengaturan jarak antar grup form */
        .form-group {
            margin-bottom: 20px;
        }
        /* Styling label pada input */
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #34495e;
            font-size: 14px;
        }
        /* Styling elemen select (dropdown) dan input teks/angka */
        .form-group select, .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            background-color: #fff;
            transition: border-color 0.2s;
        }
        /* Efek saat elemen input atau select sedang diklik/fokus */
        .form-group select:focus, .form-group input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        /* Mengatur tata letak tombol di bagian bawah form */
        .btn-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 25px;
        }
        /* Styling tombol submit (proses transaksi) */
        button[type="submit"] {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        button[type="submit"]:hover {
            background-color: #219653;
        }
        /* Styling tombol kembali */
        .btn-kembali {
            background-color: #7f8c8d;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            display: inline-block;
            transition: background-color 0.2s;
        }
        .btn-kembali:hover {
            background-color: #95a5a6;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Form Transaksi Penjualan</h2>
        <!-- Form menggunakan method POST untuk mengirim data secara aman ke file PHP ini sendiri -->
        <form action="" method="POST">
            
            <!-- Input Nama Pelanggan (Berupa teks bebas agar bisa diketik manual) -->
            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan</label>
                <input type="text" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukkan nama pelanggan..." required>
            </div>

            <!-- Pilihan Produk -->
            <div class="form-group">
                <label for="id_produk">Pilih Produk</label>
                <select name="id_produk" id="id_produk" required>
                    <option value="">-- Pilih Produk & Stok --</option>
                    <?php
                    // Mengambil produk yang stoknya masih ada (> 0) dari tabel 'produk'
                    $produk = mysqli_query($conn, "SELECT * FROM produk WHERE stok > 0");
                    while ($pr = mysqli_fetch_array($produk)) {
                        // Menampilkan nama produk beserta sisa stok dan format harga Rupiah
                        echo "<option value='".$pr['id_produk']."'>".$pr['nama_produk']." (Stok: ".$pr['stok']." - Rp ".number_format($pr['harga'], 0, ',', '.').")</option>";
                    }
                    ?>
                </select>
            </div>
            
            <!-- Input Jumlah Beli -->
            <div class="form-group">
                <label for="jumlah_beli">Jumlah Beli</label>
                <!-- Minimal pembelian diset 1 menggunakan atribut min="1" -->
                <input type="number" id="jumlah_beli" name="jumlah_beli" min="1" placeholder="Masukkan jumlah..." required>
            </div>
            
            <!-- Tombol Aksi -->
            <div class="btn-container">
                <button type="submit" name="simpan_transaksi">Proses Transaksi</button>
                <a href="index.php" class="btn-kembali">Kembali</a>
            </div>
        </form>
    </div>

</body>
</html>