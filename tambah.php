<?php
// Memanggil file koneksi.php untuk menghubungkan aplikasi dengan database MySQL
include 'koneksi.php';

// Mengecek apakah tombol dengan atribut name="submit" telah ditekan/disubmit oleh pengguna
if (isset($_POST['submit'])) {
    // Menangkap data inputan nama produk, harga, dan stok yang dikirimkan dari form (metode POST)
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Menjalankan query SQL untuk memasukkan (insert) data baru ke dalam tabel 'produk'
    $query = mysqli_query($conn, "INSERT INTO produk (nama_produk, harga, stok) VALUES ('$nama_produk', '$harga', '$stok')");

    // Mengecek apakah proses query penambahan data berhasil dijalankan
    if ($query) {
        // Jika berhasil, tampilkan pesan pop-up sukses dan alihkan halaman kembali ke index.php
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='index.php';</script>";
    } else {
        // Jika gagal, tampilkan pesan pop-up pemberitahuan bahwa data gagal ditambahkan
        echo "<script>alert('Gagal menambah data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Menentukan judul halaman web yang tampil pada tab browser -->
    <title>Tambah Produk</title>
</head>
<body>
    <!-- Menampilkan judul bagian atas halaman -->
    <h2>Tambah Produk Baru</h2>

    <!-- Form untuk mengirimkan data produk baru menggunakan metode POST -->
    <form action="" method="POST">
        <table>
            <!-- Baris input untuk Nama Produk -->
            <tr>
                <td>Nama Produk</td>
                <td><input type="text" name="nama_produk" required></td>
            </tr>
            <!-- Baris input untuk Harga Produk -->
            <tr>
                <td>Harga</td>
                <td><input type="number" name="harga" required></td>
            </tr>
            <!-- Baris input untuk Stok Produk -->
            <tr>
                <td>Stok</td>
                <td><input type="number" name="stok" required></td>
            </tr>
            <!-- Baris tombol aksi untuk menyimpan data atau kembali -->
            <tr>
                <td></td>
                <td><button type="submit" name="submit">Simpan</button> | <a href="index.php">Kembali</a></td>
            </tr>
        </table>
    </form>
</body>
</html>