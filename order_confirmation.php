<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

if (isset($_SESSION["user_id"])) {  
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}
$cartCount = isset($_SESSION['cart']) ? $_SESSION['cart'] : 0;

$orderTotal = 10* $cartCount;

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Payment details</title>
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
            <h2>Payment details</h2>

            <?php if ($user): ?>
            <p>Please complete the payment, <?= htmlspecialchars($user['username']) ?>!
            </p>
            <ul>
                <li><?= $cartCount ?> Choco cookies:</li>
            </ul>
            <p>Please pay: <?= htmlspecialchars($orderTotal) ?> coooookieCoins to ????</p>

            <?php else: ?>
            <p>You are not logged in. Please log in to confirm your order.</p>
            <?php endif; ?>
        </main>

        <footer>
            <p>&copy; 2023 Web Shop</p>
        </footer>
    </body>

</html>
