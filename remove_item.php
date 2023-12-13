<?php
$servername = "localhost"; // Ganti dengan nama server database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "dbshoesstore"; // Ganti dengan nama database Anda

// Mendapatkan ID item yang akan dihapus dari permintaan POST
$itemId = $_POST['id'];

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menghapus item produk berdasarkan ID
$sql = "DELETE FROM cart WHERE id = $itemId";
if ($conn->query($sql) === TRUE) {
    echo json_encode(array("status" => "success", "message" => "Item produk berhasil dihapus."));
} else {
    echo json_encode(array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error));
}
// ...


// Menutup koneksi
$conn->close();
?>
