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
    <?php
    session_start();

    // Check if the user is already logged in
    if (isset($_SESSION['username'])) {
        // Redirect to index.php if user is already logged in
        header("Location: index.php");
        exit();
    }

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Connect to the database
        $host = 'localhost';
        $db = 'dbshoesstore';
        $user = 'root';
        $pass = '';

        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

        // Query the database for the user
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Check if the user exists
        if ($stmt->rowCount() > 0) {
            // Set the session variable
            $_SESSION['username'] = $username;

            // Redirect to index.php after successful login
            header("Location: index.php");
            exit();
        } else {
            $errorMessage = "Invalid username or password.";
        }
    }
    ?>

    <section id="login">
        <h2>Log In</h2>
        <form method="POST" action="">
            <?php if (isset($errorMessage)): ?>
            <div class="error"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" style="margin-top: 140px;">Login</button>
        </form>
        <div class="member">
            Not a member? <a href="./signup.php">Register Now</a>
        </div>
    </section>
    
</body>
</html>
