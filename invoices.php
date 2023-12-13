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
    <section id="invheader" class="section-inv">
        <div class="left-icon">
            <h2><a href="hapus_data.php">ShoesSpaceHub</a></h2>
        </div>
        <div class="right-icon">
            <h4>INVOICE</h4>
        </div>
    </section>

    <section id="invsubheader" class="section-inv">
        <div class="invPenjual">
            <h3>DITERBITKAN ATAS NAMA</h3>
            <table>
                <tr>
                    <td class="kiri">Penjual</td>
                    <td class="titikdua">:</td>
                    <td>ShoesSpaceHub</td>
                </tr>
            </table>
        </div>
        <div class="invPembeli">
            <h3>UNTUK</h3>
            <table>
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
                    }

                    // Query untuk mengambil data dari tabel faktur (invoices)
                    $query = "SELECT nama, telepon, alamat FROM invoices WHERE id = (
                      SELECT MAX(id) 
                      FROM invoices
                    )
                    ";
                    $result = mysqli_query($koneksi, $query);

                    // Periksa apakah data tersedia
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>
                                    <td class="kiri">Nama</td>
                                    <td class="titikdua">:</td>
                                    <td>' . $row['nama'] . '</td>
                                </tr>
                                <tr>
                                    <td class="kiri">No Telepon</td>
                                    <td class="titikdua">:</td>
                                    <td>' . $row['telepon'] . '</td>
                                </tr>
                                <tr>
                                    <td class="kiri">Alamat</td>
                                    <td class="titikdua">:</td>
                                    <td>' . $row['alamat'] . '</td>
                                </tr>';
                        }
                    } else {
                        echo "Data tidak ditemukan";
                    }

                    // Tutup koneksi ke database
                    mysqli_close($koneksi);
                ?>
            </table>
        </div>
    </section>

    <section id="inv" class="section-inv">
        <table width="100%">
            <h3>DAFTAR BELANJA</h3>
            <br>
            <thead>
                <tr>
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
                    echo "<tr><td colspan='9'>DAFTAR BELANJA KOSONG</td></tr>";
                }

                // Menutup koneksi
                $conn->close();
                ?>
            </tbody>
        </table>
    </section>

    <section id="invpembayaran" class="section-inv">
        <div class="invPenjual">
            <h3>METODE PEMBAYARAN</h3>
            <?php
            // Koneksi ke database
            $koneksi = mysqli_connect($host, $username, $password, $database);

            // Cek koneksi
            if (mysqli_connect_errno()) {
                echo "Koneksi database gagal: " . mysqli_connect_error();
            }

            // Query untuk mengambil data metode pembayaran dari tabel invoices
            $queryMetode = "SELECT metode FROM invoices";
            $resultMetode = mysqli_query($koneksi, $queryMetode);

            // Periksa apakah data tersedia
            if (mysqli_num_rows($resultMetode) > 0) {
                $rowMetode = mysqli_fetch_assoc($resultMetode);
                echo "<p>" . $rowMetode['metode'] . "</p>";
            } else {
                echo "Data metode pembayaran tidak ditemukan";
            }

            // Tutup koneksi ke database
            mysqli_close($koneksi);
            ?>
        </div>
        <div class="invPembeli">
            <h3>TOTAL PEMBAYARAN</h3>
            <?php
            // Koneksi ke database (dilakukan koneksi ulang)
            $koneksi = mysqli_connect($host, $username, $password, $database);

            // Cek koneksi
            if (mysqli_connect_errno()) {
                echo "Koneksi database gagal: " . mysqli_connect_error();
            }

            // Query untuk mengambil data total pembayaran dari tabel invoices
            $queryTotal = "SELECT total FROM invoices";
            $resultTotal = mysqli_query($koneksi, $queryTotal);

            // Periksa apakah data tersedia
            if (mysqli_num_rows($resultTotal) > 0) {
                $rowTotal = mysqli_fetch_assoc($resultTotal);
                echo "<p>" . $rowTotal['total'] . "</p>";
            } else {
                echo "Data total pembayaran tidak ditemukan";
            }

            // Tutup koneksi ke database
            mysqli_close($koneksi);
            ?>
        </div>
    </section>
</body>
</html>