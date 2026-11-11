<?php
// Memanggil file koneksi.php untuk menghubungkan aplikasi dengan database MySQL
include 'koneksi.php';

// Mengecek apakah tombol dengan atribut name="submit" pada form input telah ditekan
if (isset($_POST['submit'])) {
    // Menangkap data inputan nama produk, harga, dan stok dari form (metode POST)
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Menjalankan query SQL untuk memasukkan data baru ke dalam tabel 'produk'
    $query = mysqli_query($conn, "INSERT INTO produk (nama_produk, harga, stok) VALUES ('$nama_produk', '$harga', '$stok')");

    // Mengecek apakah proses penyimpanan data berhasil atau gagal
    if ($query) {
        // Jika berhasil, tampilkan alert sukses dan muat ulang halaman itu sendiri
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='inputdata.php';</script>";
    } else {
        // Jika gagal, tampilkan alert pemberitahuan gagal
        echo "<script>alert('Gagal menambah data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Menentukan judul halaman web yang tampil pada tab browser -->
    <title>Input & Daftar Data Barang</title>
    <style>
        /* Pengaturan dasar mereset margin, padding, dan teknik box-sizing */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        /* Styling latar belakang dan font utama halaman */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            padding: 30px;
        }
        /* Kotak kontainer utama pembungkus seluruh konten halaman */
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        /* Styling untuk bagian judul form di bagian atas */
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 22px;
            border-bottom: 2px solid #eaeaea;
            padding-bottom: 12px;
        }
        /* Pengaturan tata letak form input */
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #34495e;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccd1d9;
            border-radius: 6px;
            font-size: 14px;
        }
        .form-group input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        /* Tombol simpan data */
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
        /* Garis pembatas antara bagian Form Input di atas dan Tabel Data di bawah */
        .divider {
            margin: 40px 0 20px 0;
            border: none;
            border-top: 2px solid #eaeaea;
        }
        /* Bagian Kotak Pencarian (Search Box) */
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        .search-box input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ccd1d9;
            border-radius: 6px;
            font-size: 14px;
        }
        .search-box button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
        .search-box button:hover {
            background-color: #2980b9;
        }
        .btn-reset {
            background-color: #95a5a6;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
        }
        .btn-reset:hover {
            background-color: #7f8c8d;
        }
        /* Styling struktur tabel daftar barang di bagian bawah */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }
        th {
            background-color: #34495e;
            color: white;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        /* Styling tombol aksi (Edit & Hapus) agar rapi berdampingan */
        .action-container {
            display: flex;
            gap: 6px;
        }
        .btn-action {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
            text-align: center;
        }
        .btn-edit {
            background-color: #f39c12;
        }
        .btn-edit:hover {
            background-color: #d68910;
        }
        .btn-hapus {
            background-color: #e74c3c;
        }
        .btn-hapus:hover {
            background-color: #c0392b;
        }
        .btn-kembali {
            background-color: #7f8c8d;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            display: inline-block;
            margin-top: 20px;
            transition: background-color 0.2s;
        }
        .btn-kembali:hover {
            background-color: #95a5a6;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- BAGIAN ATAS: Form Input Produk Baru -->
        <h2>Tambah Produk Baru</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" placeholder="Masukkan nama produk..." required>
            </div>
            
            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="number" id="harga" name="harga" placeholder="Contoh: 12000" required>
            </div>
            
            <div class="form-group">
                <label for="stok">Stok Barang</label>
                <input type="number" id="stok" name="stok" placeholder="Contoh: 100" required>
            </div>
            
            <button type="submit" name="submit">Simpan Data</button>
        </form>

        <!-- Garis Pemisah antara Form dan Tabel -->
        <hr class="divider">

        <!-- BAGIAN BAWAH: Tabel Daftar Barang & Fitur Pencarian -->
        <h2>Daftar Barang</h2>
        
        <!-- Form Pencarian Data -->
        <form action="" method="GET" class="search-box">
            <input type="text" name="cari" placeholder="Cari nama produk..." value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
            <button type="submit">Cari</button>
            <?php if(isset($_GET['cari']) && $_GET['cari'] != ''): ?>
                <a href="inputdata.php" class="btn-reset">Reset</a>
            <?php endif; ?>
        </form>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Inisialisasi nomor urut baris tabel
                $no = 1;
                
                // Logika Pencarian: Jika tombol cari dikirim, filter berdasarkan nama produk
                if (isset($_GET['cari']) && $_GET['cari'] != '') {
                    $keyword = mysqli_real_escape_string($conn, $_GET['cari']);
                    $data = mysqli_query($conn, "SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%'");
                } else {
                    // Jika tidak mencari, tampilkan seluruh data produk
                    $data = mysqli_query($conn, "SELECT * FROM produk");
                }
                
                // Mengecek apakah data di dalam database tersedia (lebih dari 0 baris)
                if (mysqli_num_rows($data) > 0) {
                    // Perulangan untuk menampilkan setiap baris data ke dalam tabel
                    while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                        <!-- Menampilkan nomor urut -->
                        <td><?php echo $no++; ?></td>
                        
                        <!-- Menampilkan nama produk dengan pengaman htmlspecialchars -->
                        <td><?php echo htmlspecialchars($d['nama_produk']); ?></td>
                        
                        <!-- Menampilkan harga dalam format mata uang Rupiah -->
                        <td>Rp <?php echo number_format($d['harga'], 0, ',', '.'); ?></td>
                        
                        <!-- Menampilkan jumlah stok -->
                        <td><?php echo $d['stok']; ?></td>
                        
                        <!-- Kolom tombol aksi Edit dan Hapus yang sudah dirapikan sejajar -->
                        <td>
                            <div class="action-container">
                                <a href="edit.php?id=<?php echo $d['id_produk']; ?>" class="btn-action btn-edit">Edit</a> 
                                <a href="hapus.php?id=<?php echo $d['id_produk']; ?>" class="btn-action btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                    }
                } else {
                    // Jika data kosong atau pencarian tidak ditemukan, tampilkan pesan informasi
                    echo "<tr><td colspan='5' style='text-align:center;'>Data barang tidak ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Tombol untuk kembali ke menu utama -->
        <a href="index.php" class="btn-kembali">← Menu Utama</a>
    </div>

</body>
</html>