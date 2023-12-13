<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dbshoesstore';
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

// Query untuk menghapus data dari tabel cart
$queryHapusCart = "DELETE FROM cart";
$resultHapusCart = mysqli_query($koneksi, $queryHapusCart);

// Periksa apakah proses penghapusan berhasil
if ($resultHapusCart) {
    // Redirect ke halaman index.php
    header("Location: index.php");
    exit();
} else {
    echo "Gagal menghapus data.";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
?>