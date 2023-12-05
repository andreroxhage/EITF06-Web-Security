<?php
// Set session timeout to 30 minutes
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params([
    'lifetime' => 1800, // match your session timeout
    'path' => '/',
    'domain' => '',
    'secure' => true, // Send cookie only over HTTPS
    'httponly' => true, // Prevent client-side access to the cookie
    'samesite' => 'Strict', // prevents cookie from being sent by the browser with cross-site requests. Prevents CSRF-attacks
]);
session_start();

$loggedIn = false;
$user = [];

if (isset($_SESSION["user_id"])) {  
    $mysqli = require __DIR__ . "/database.php";
    
    $userId = $_SESSION["user_id"];
    $sql = "SELECT * FROM user WHERE id = ?";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $loggedIn = true;
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addToCart'])) {    
    // Increment the cart count in the session
    $_SESSION['cart'] = isset($_SESSION['cart']) ? $_SESSION['cart'] + 1 : 0;
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

            <?php if ($loggedIn): ?>

            <!-- Safe version -->
            <p>Welcome back <b><?= htmlspecialchars($user["username"]) ?></b></p>

            <!-- Unsafe version -->
            <!--<p>Welcome back <b><?= $user["username"] ?></b></p> -->

            <button><a id="black_link" href="logout.php">Log out</a></button>

            <!-- Add 1 to cart -->
            <form method="post" action="">
                <input type="submit" name="addToCart" value="Add to Cart">
            </form>

            <?php else: ?>
            <h3>Please log in or sign up!</h3>

            <?php endif; ?>

            <div id="cookie-container">
                <h2>Choco Cookie</h2>

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
