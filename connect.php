<?php
$servername = "localhost"; // Ganti dengan nama server database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "dbshoesstore"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan data dari JavaScript
$nama = $_POST['nama'];
$harga = $_POST['harga'];
$ukuran = $_POST['ukuran'];
$jumlah = $_POST['jumlah'];

// Masukkan data ke dalam tabel database
$sql = "INSERT INTO cart (nama, harga, ukuran, jumlah) VALUES ('$nama', '$harga', '$ukuran', '$jumlah')";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil disimpan";
} else {
    echo "Terjadi kesalahan: " . $conn->error;
}

// Menutup koneksi
$conn->close();
?>
