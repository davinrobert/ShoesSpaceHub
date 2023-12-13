<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoesSpace</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body> 
    <section id="header">
        <div class="pilihan">
            <ul><a href="nike.php"><p>Nike</p></a></ul>
            <ul><a href="adidas.php"><p>Adidas</p></a></ul>
            <ul><a href="nb.php"><p>New Balance</p></a></ul>
        </div>
        <div class="logo"><a href="index.php"><h1>ShoesSpaceHub</h1></a></div>
        <div class="right-icon">
            <?php
            // Cek apakah pengguna sudah login
            session_start();
            if (isset($_SESSION['username'])) {
                // Jika pengguna sudah login, tampilkan status login
                echo '<span class="login-status">' . $_SESSION['username'] . '</span>';
            } else {
                // Jika pengguna belum login, maka tidak bisa membuka halaman cart dan diarahkan pada halaman login
                header("Location: login.php");
                exit();
            }
            ?>
            <a href="cart.php"><i class="fa-solid fa-cart-shopping" style="color: #000000;"></i></a>
        </div>
    </section>

    <section id="cart" class="section-p1">
        <table width="100%">
            <h4>Keranjang Anda</h4>
            <br>
            <thead>
                <tr>
                    <td>Hapus</td>
                    <td>No</td>
                    <td>Nama Produk</td>
                    <td>Harga</td>
                    <td>Ukuran</td>
                    <td>Jumlah</td>
                    <td>Sub Total</td>
                </tr>
            </thead>
            <tbody>
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

                // Mengambil data dari tabel
                $sql = "SELECT * FROM cart";
                $result = $conn->query($sql);

                $total = 0;

                // Menampilkan data dalam tabel
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='hapus'><a href='#' onclick='removeItem(".$row["id"].")'><i class='fa-solid fa-times-circle'></i></a></td>";
                        echo "<td class='no'>".$row["id"]."</td>";
                        echo "<td class='namaproduk'>".$row["nama"]."</td>";
                        echo "<td class='harga'>".$row["harga"]."</td>";
                        echo "<td class='ukuran'>".$row["ukuran"]."</td>";
                        echo "<td class='jumlah'>".$row["jumlah"]."</td>";

                        $subtotal = 0;
                        if (is_numeric($row["harga"]) && is_numeric($row["jumlah"])) {
                            $subtotal = $row["harga"] * $row["jumlah"];
                        }

                        $total += $subtotal;

                        echo "<td class='subtotal'>".$subtotal."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Keranjang kosong.</td></tr>";
                }

                // Menutup koneksi
                $conn->close();
                ?>
            </tbody>
        </table>
    </section>

    <section id="checkout" class="section-p1">
        <?php
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
            // Retrieve form data
            $nama = $_POST['nama'];
            $alamat = $_POST['alamat'];
            $telepon = $_POST['telepon'];
            $metode_pembayaran = $_POST['metode_pembayaran'];

            // Connect to the database
            $host = 'localhost';
            $db = 'dbshoesstore';
            $user = 'root';
            $pass = '';

            $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

            // Insert data into invoices table
            $stmt = $conn->prepare("INSERT INTO invoices (nama, alamat, telepon, metode, total) VALUES (:nama, :alamat, :telepon, :metode, :total)");
            $stmt->bindParam(':nama', $nama);
            $stmt->bindParam(':alamat', $alamat);
            $stmt->bindParam(':telepon', $telepon);
            $stmt->bindParam(':metode', $metode_pembayaran);
            $stmt->bindParam(':total', $total); // You need to define $total variable

            // Execute the query
            $stmt->execute();

            // Redirect to invoices.php
            header("Location: invoices.php");
            exit();
        }
        ?>

        <div id="pembeli">
            <h3>Halaman Pembayaran</h3>
            <br>
            <div>
                <form method="POST" action="">
                    <p>Nama Lengkap:</p>
                    <input type="text" name="nama" placeholder="Masukkan Nama Anda" required>
                    <p>Alamat:</p>
                    <input type="text" name="alamat" placeholder="Masukkan Alamat Yang Sesuai" required>
                    <p>No Telepon:</p>
                    <input type="text" name="telepon" placeholder="Masukkan Nomor Telepon" required>
                    <p>Pilih Metode Pembayaran:</p>
                    <select name="metode_pembayaran" required>
                        <option value="">Metode Pembayaran</option>
                        <option value="COD">COD (Bayar Ditempat)</option>
                        <option value="ShoesPay Later">ShoesPay Later</option>
                        <option value="BRI Direct Debit">BRI Direct Debit</option>
                        <option value="BCA One Klik">BCA One Klik</option>
                    </select>
                </div>
            </div>
        </div>
        <div id="subtotal">
            <h3>Total Pembayaran</h3>
            <br>
            <table>
                <tr class="trtotal">
                    <td class="total">Total</td>
                    <td><?php echo $total; ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <form method="POST" action="">
                            <button type="submit" name="checkout">Checkout</button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </section>
    
    <footer class="section-p1">
        <div class="col">
            <h1 class="logo">ShoesSpaceHub</h1>
            <p>2023, Sengkuni - ShoesSpaceHub</p>
            <br>
            <br>
        </div>
        <div class="col coll">
            <h4>Contact</h4>
            <p><strong>Address</strong> 66373 Kampak, Trenggalek</p>
            <p><strong>Phone</strong> +62 5917 544 4954</p>
            <p><strong>Hours</strong> 10:00 - 18:00, Mon - Sat</p>
            <br>
            <div class="follow">
                <h4>Follow us</h4>
                <div class="icon">
                    <i class="fa-brands fa-facebook" style="color: #000000;"></i>
                    <i class="fa-brands fa-twitter" style="color: #000000;"></i>
                    <i class="fa-brands fa-instagram" style="color: #000000;"></i>
                    <i class="fa-brands fa-youtube" style="color: #000000;"></i>
                </div>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
    <script>
    // Membuat fungsi untuk menangani klik pada ikon penghapusan
    function removeItem(itemId) {
        // Mengirim permintaan AJAX untuk menghapus item produk dari database
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "remove_item.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Jika permintaan AJAX berhasil, hapus baris <tr> dari tabel
                var row = document.querySelector("tr[data-id='" + itemId + "']");
                if (row) {
                    row.parentNode.removeChild(row);
                }
                // Muat ulang halaman setelah penghapusan berhasil dilakukan
                location.reload();
            }
        };
        xhr.send("id=" + itemId);
    }
    </script>
</body>
</html>

