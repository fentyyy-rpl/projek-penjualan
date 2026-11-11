<?php 
// Memanggil file koneksi.php untuk menghubungkan database MySQL
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <style>
        /* Styling utama untuk latar belakang dan font halaman */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }
        /* Kotak kontainer utama untuk membungkus konten tabel */
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        /* Bagian judul halaman dan tombol navigasi */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }
        .header-section h2 {
            color: #2c3e50;
            margin: 0;
        }
        /* Styling untuk grup tombol navigasi */
        .btn-group a {
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
            color: white;
            display: inline-block;
        }
        /* Tombol untuk kembali ke menu utama */
        .btn-kembali {
            background-color: #7f8c8d;
        }
        .btn-kembali:hover {
            background-color: #95a5a6;
        }
        /* Styling Kotak Pencarian (Search Box) */
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .search-box input {
            flex: 1;
            padding: 9px 12px;
            border: 1px solid #ccd1d9;
            border-radius: 6px;
            font-size: 14px;
        }
        .search-box input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        .search-box button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 9px 18px;
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
            padding: 9px 14px;
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
        /* Styling struktur tabel data */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #34495e;
            color: white;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header Halaman -->
        <div class="header-section">
            <h2>Data Barang Penjualan</h2>
            <div class="btn-group">
                <!-- Tombol navigasi kembali ke menu utama -->
                <a href="index.php" class="btn-kembali">← Menu Utama</a>
            </div>
        </div>

        <!-- Form Fitur Pencarian (Search) -->
        <form action="" method="GET" class="search-box">
            <input type="text" name="cari" placeholder="Cari nama produk..." value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
            <button type="submit">Cari</button>
            <?php if(isset($_GET['cari']) && $_GET['cari'] != ''): ?>
                <a href="databarang.php" class="btn-reset">Reset</a>
            <?php endif; ?>
        </form>

        <!-- Tabel Menampilkan Data Barang -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Inisialisasi nomor urut baris tabel
                $no = 1;
                
                // Logika Pencarian: Cek apakah pengguna memasukkan kata kunci pencarian
                if (isset($_GET['cari']) && $_GET['cari'] != '') {
                    $keyword = mysqli_real_escape_string($conn, $_GET['cari']);
                    // Query untuk memfilter data berdasarkan nama produk yang dicari
                    $data = mysqli_query($conn, "SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%'");
                } else {
                    // Jika tidak mencari, jalankan query untuk mengambil seluruh data dari tabel 'produk'
                    $data = mysqli_query($conn, "SELECT * FROM produk");
                }
                
                // Mengecek apakah data di dalam database ditemukan / lebih dari 0 baris
                if (mysqli_num_rows($data) > 0) {
                    // Melakukan perulangan (looping) untuk menampilkan setiap baris data
                    while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                        <!-- Menampilkan nomor urut yang terus bertambah -->
                        <td><?php echo $no++; ?></td>
                        
                        <!-- Menampilkan nama produk dengan fungsi htmlspecialchars untuk mencegah celah keamanan XSS -->
                        <td><?php echo htmlspecialchars($d['nama_produk']); ?></td>
                        
                        <!-- Menampilkan harga produk dalam format mata uang Rupiah -->
                        <td>Rp <?php echo number_format($d['harga'], 0, ',', '.'); ?></td>
                        
                        <!-- Menampilkan jumlah stok barang -->
                        <td><?php echo $d['stok']; ?></td>
                    </tr>
                    <?php 
                    }
                } else {
                    // Jika data kosong atau pencarian tidak ditemukan, tampilkan pesan informasi di dalam tabel
                    echo "<tr><td colspan='4' style='text-align:center;'>Data barang tidak ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>