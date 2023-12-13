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
            <ul><a class="active" href="adidas.php"><p>Adidas</p></a></ul>
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
                // Jika pengguna belum login, tampilkan tautan login
                echo '<a href="login.php" class="login-status">Login Dahulu</a>';
            }
            ?>
            <a href="cart.php"><i class="fa-solid fa-cart-shopping" style="color: #000000;"></i></a>
        </div>
    </section>

    <section id="moto" class="section-p1">
        <p style="font-size: 20px;">ONE OF THE FINEST SNEAKER STORE IN INDONESIA</p>
        <p >AUTHENTIC. TRUSTED. BEST PRICE.</p>
    </section>

    <section id="product1" class="section-p1">
        <br>
        <h2>Adidas Collection Product</h2>
        <br>
        <div class="pro-container">
            <?php
            // Langkah 1: Menghubungkan ke database
            $koneksi = mysqli_connect("localhost", "root", "", "dbshoesstore");

            // Langkah 2: Mengeksekusi kueri SQL untuk mengambil data produk
            $query = "SELECT * FROM products WHERE brand = 'adidas'";
            $result = mysqli_query($koneksi, $query);

            // Langkah 3: Menghasilkan kode HTML untuk setiap produk
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                    <div class="pro" onclick="window.location.href=\'detailproduct.php?id=' . $row['id'] . '\';">
                        <img src="' . $row['image1'] . '" alt="">
                        <div class="des">
                            <span>' . $row['brand'] . '</span>
                            <h5>' . $row['name'] . '</h5>
                            <h4>' . $row['price'] . '</h4>
                        </div>
                        <div class="cart">
                            <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                        </div>
                    </div>
                ';
            }

            // Langkah 4: Menutup koneksi ke database
            mysqli_close($koneksi);
            ?>
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

</script>
</body>
</html>

<!-- test -->