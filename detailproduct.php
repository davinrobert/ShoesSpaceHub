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
                // Jika pengguna belum login, tampilkan tautan login
                echo '<a href="login.php" class="login-status">Login Dahulu</a>';
            }
            ?>
            <a href="cart.php"><i class="fa-solid fa-cart-shopping" style="color: #000000;"></i></a>
        </div>
    </section>

    <section id="prodetail" class="section-p1">
        <?php

        // Langkah 1: Menghubungkan ke database
        $koneksi = mysqli_connect("localhost", "root", "", "dbshoesstore");

        // Langkah 2: Mengecek apakah parameter id telah diberikan
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Langkah 3: Mengeksekusi kueri SQL untuk mengambil data produk berdasarkan id
            $query = "SELECT * FROM products WHERE id = $id";
            $result = mysqli_query($koneksi, $query);

            // Langkah 4: Memeriksa apakah data ditemukan
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                // Langkah 5: Mengisi data dari database ke dalam variabel
                $name = $row['name'];
                $price = $row['price'];
                $image1 = $row['image1'];
                $image2 = $row['image2'];
                $image3 = $row['image3'];

                // Langkah 6: Menghasilkan kode HTML untuk tampilan detail produk
                echo '
                    <div class="single-pro-image">
                        <img src="' . $image1 . '" width="100%" id="MainImg" alt="">

                        <div class="small-img-group">
                            <div class="small-img-col">
                                <img src="' . $image1 . '" width="100%" class="small-img" alt="">
                            </div>
                            <div class="small-img-col">
                                <img src="' . $image2 . '" width="100%" class="small-img" alt="">
                            </div>
                            <div class="small-img-col">
                                <img src="' . $image3 . '" width="100%" class="small-img" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="single-pro-details">
                        <h3>' . $name . '</h3>
                        <br>
                        <h2>' . $price . '</h2>
                        <p>BNIB & Authentic</p>
                        <br>
                        <select>
                            <option>Select Size</option>
                            <option>40</option>
                            <option>41</option>
                            <option>42</option>
                            <option>43</option>
                        </select>
                        <input type="number" value="1">
                ';

                // Periksa apakah pengguna telah login
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    echo '<button class="normal">Add To Cart</button>';
                } else {
                    echo '<button class="normal" onclick="redirectToLogin()">Add To Cart</button>';
                }

                echo '
                    </div>
                ';
            } else {
                echo "Produk tidak ditemukan.";
            }
        } else {
            echo "ID produk tidak diberikan.";
        }

        // Langkah 7: Menutup koneksi ke database
        mysqli_close($koneksi);
        ?>

    </section>

    <section id="product1" class="section-p1">
        <h2>Most Popular Product</h2>
        <p>Summer Collection New Morgen Design</p>
        <div class="pro-container">
            <?php
            // Langkah 1: Menghubungkan ke database
            $koneksi = mysqli_connect("localhost", "root", "", "dbshoesstore");

            // Langkah 2: Mengeksekusi kueri SQL untuk mengambil data produk
            $query = "SELECT * FROM products WHERE id IN (1001, 2003, 2004, 3001)";
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

    <script>
        var MainImg = document.getElementById("MainImg");
        var smallimg = document.getElementsByClassName("small-img");

        smallimg[0].onclick = function(){
            MainImg.src = smallimg[0].src;
        }
        smallimg[1].onclick = function(){
            MainImg.src = smallimg[1].src;
        }
        smallimg[2].onclick = function(){
            MainImg.src = smallimg[2].src;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
    <script>
        $(document).ready(function() {
            $("button").click(function() {
                var nama = $("h3").text();
                var harga = $("h2").text();
                var ukuran = $("select").val();
                var jumlah = $("input[type='number']").val();

                // Kirim data menggunakan AJAX ke file PHP
                $.ajax({
                    url: "connect.php",
                    type: "POST",
                    data: {
                        nama: nama,
                        harga: harga,
                        ukuran: ukuran,
                        jumlah: jumlah
                    },
                    success: function(response) {
                        alert("Produk berhasil ditambahkan ke keranjang!");
                    },
                    error: function() {
                        alert("Terjadi kesalahan. Silakan coba lagi.");
                    }
                });
            });
        });
    </script>

    <script>
        function redirectToLogin() {
            window.location.href = "login.php";
        }
    </script>

    <script src="script.js"></script>

</script>
</body>
</html>

