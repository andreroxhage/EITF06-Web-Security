<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Your Web Shop</title>
    </head>

    <body>
        <header>
            <h1>Web Shop</h1>
        </header>
        <nav>
            <ul>
                <li><a href="/EITF06-Web-Security/index.php">Home</a></li>
                <li><a href="/EITF06-Web-Security/signup.php">Sign Up</a></li>
                <li><a href="/EITF06-Web-Security/login.php">Login</a></li>
                <li><a href="/EITF06-Web-Security/cart.php">Shopping Cart</a></li>
            </ul>
        </nav>
        <main>
            <h2 id="signup-h2">Welcome to Your Web Shop!</h2>
            <?php
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        echo 'Welcome, ' . $_SESSION['username'] . '!';
        // Add other content for logged-in users
    } else {
        echo '<p id="signup-h2">Welcome, Guest!</p> <a href="login.php" id="signup-h2">Please login</a>.';
    }
    ?>
        </main>
        <footer>
            <p>&copy; 2023 Web Shop</p>
        </footer>
    </body>

</html>
