<?php
session_start();


if (isset($_SESSION["user_id"])) {  
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}
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

            <?php if (isset($user)): ?>

            <p>Welcome back <b><?= htmlspecialchars($user["username"]) ?></b></p>


            <button><a id="black_link" href="logout.php">Log out</a></button>

            <?php else: ?>
            <h3>Please log in or sign up!</h3>



            <?php endif; ?>

            <div id="cookie-container">
                <h2>Item 1</h2>

                <?php
                if (isset($_POST['addToSession'])) {
                    // Perform any logic to add to the session variable
                    $_SESSION['cart'] = isset($_SESSION['cart']) ? $_SESSION['counter'] + 1 : 1;
                    
                }
                ?>

                <form method="post" action="">
                    <input type="submit" name="Add to cart" value="Add to Cart">
                </form>

                <img id="cookie"
                    src="
                    https://www.dessertfortwo.com/wp-content/uploads/2023/04/Single-Serve-Chocolate-Chip-Cookie-5-735x1103.jpg"
                    alt="cookie">
            </div>
        </main>
        <footer>
            <p>&copy; 2023 Web Shop</p>
        </footer>
    </body>

</html>
