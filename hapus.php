<?php
// Memanggil file koneksi.php untuk menghubungkan aplikasi dengan database MySQL
include 'koneksi.php';

// Mengambil nilai parameter 'id' yang dikirimkan melalui URL (metode GET) untuk menentukan data produk yang akan dihapus
$id = $_GET['id'];

// Menjalankan query SQL untuk menghapus data dari tabel 'produk' berdasarkan 'id_produk' yang dipilih
$hapus = mysqli_query($conn, "DELETE FROM produk WHERE id_produk = '$id'");

// Mengecek apakah proses query penghapusan data berhasil dijalankan
if ($hapus) {
    // Jika berhasil, tampilkan pesan pop-up sukses dan alihkan halaman kembali ke databarang.php
    echo "<script>alert('Data berhasil dihapus!'); window.location='databarang.php';</script>";
} else {
    // Jika gagal, tampilkan pesan pop-up pemberitahuan gagal dan alihkan kembali ke databarang.php
    echo "<script>alert('Gagal menghapus data!'); window.location='databarang.php';</script>";
}
?>