<?php
// Memanggil file koneksi.php untuk menghubungkan aplikasi dengan database
include 'koneksi.php';

// Mengambil nilai parameter 'id' yang dikirimkan melalui URL (metode GET)
$id = $_GET['id'];

// Menjalankan query SQL untuk mencari dan mengambil data produk berdasarkan 'id_produk'
$data = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = '$id'");

// Mengubah hasil query database ke dalam bentuk array agar nilainya dapat dibaca dan ditampilkan ke dalam form
$d = mysqli_fetch_array($data);

// Mengecek apakah tombol dengan atribut name="update" telah ditekan/disubmit oleh pengguna
if (isset($_POST['update'])) {
    // Menangkap data inputan baru (nama produk, harga, dan stok) yang dikirimkan dari form (metode POST)
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Menjalankan query SQL untuk memperbarui data produk di dalam database berdasarkan ID
    $update = mysqli_query($conn, "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stok='$stok' WHERE id_produk='$id'");

    // Mengecek apakah proses query update berhasil atau gagal dijalankan
    if ($update) {
        // Jika berhasil, tampilkan pesan pop-up sukses dan alihkan halaman kembali ke index.php
        echo "<script>alert('Data berhasil diubah!'); window.location='index.php';</script>";
    } else {
        // Jika gagal, tampilkan pesan pop-up pemberitahuan bahwa data gagal diubah
        echo "<script>alert('Gagal mengubah data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Menentukan judul halaman web yang tampil pada tab browser -->
    <title>Edit Produk</title>
</head>
<body>
    <!-- Menampilkan judul bagian atas halaman -->
    <h2>Edit Produk</h2>

    <!-- Form untuk mengubah data produk, dikirim menggunakan metode POST ke halaman itu sendiri -->
    <form action="" method="POST">
        <table>
            <!-- Baris input untuk mengubah Nama Produk -->
            <tr>
                <td>Nama Produk</td>
                <td><input type="text" name="nama_produk" value="<?php echo $d['nama_produk']; ?>" required></td>
            </tr>
            <!-- Baris input untuk mengubah Harga Produk -->
            <tr>
                <td>Harga</td>
                <td><input type="number" name="harga" value="<?php echo $d['harga']; ?>" required></td>
            </tr>
            <!-- Baris input untuk mengubah jumlah Stok Produk -->
            <tr>
                <td>Stok</td>
                <td><input type="number" name="stok" value="<?php echo $d['stok']; ?>" required></td>
            </tr>
            <!-- Baris tombol aksi untuk menyimpan perubahan atau kembali -->
            <tr>
                <td></td>
                <td><button type="submit" name="update">Update</button> | <a href="index.php">Kembali</a></td>
            </tr>
        </table>
    </form>
</body>
</html>