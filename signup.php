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
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $username = $_POST['username'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        // Check if password and confirm password match
        if ($password !== $confirmPassword) {
            $errorMessage = "Error : Password and Re-Password";
        } else {
            // TODO: Validate the form data and perform necessary checks

            // Connect to the database
            $host = 'localhost';
            $db = 'dbshoesstore';
            $user = 'root';
            $pass = '';

            $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

            // Insert the user data into the database
            $stmt = $conn->prepare("INSERT INTO users (username, name, password) VALUES (:username, :name, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            // Redirect to login page after successful registration
            header("Location: login.php");
            exit();
        }
    }
    ?>

    <section id="signup">
        <h2>Sign Up</h2>
        <form method="POST" action="">
            <?php if (isset($errorMessage)): ?>
            <div class="error"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="name" placeholder="Name" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Re-Enter Password" required>
            <button type="submit">Sign Up</button>
        </form>
        <div class="member">
            Already a member? <a href="./login.php">Login here</a>
        </div>
    </section>
</body>
</html>
