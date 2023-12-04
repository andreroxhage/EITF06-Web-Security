
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

if (isset($_SESSION["user_id"])) {  
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmCart'])) {
    // Redirect to order confirmation page
    header("Location: order_confirmation.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Shopping Cart</title>
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
            <h2>Shopping Cart</h2>

            <?php if (isset($user)): ?>
            <p>Current cart contains:
                <li><?= htmlspecialchars(isset($_SESSION['cart']) ? $_SESSION['cart'] : 0) ?> choco
                    cookies</li>
            </p>

            <form method="post" action="">
                <button type="submit" name="confirmCart">Confirm order</button>
            </form>

            <?php else: ?>
            <h3>Do you want to start shopping? Please log in or sign up first.</h3>
            <?php endif; ?>
            <header>
                <h2>Look at these nice cookies!</h2>
            </header>
            <img src="https://media.istockphoto.com/id/1176898042/sv/foto/diverse-n%C3%A4rbild-urval-av-te-kex.jpg?s=1024x1024&w=is&k=20&c=CQryVsZ3qgd6-XPWEMQjzAjGVCVegkmuwtELV6b4XRE=" alt="Trulli" width="500" height="333">

        </main>

        <footer>
            <p>&copy; 2023 Web Shop</p>
        </footer>
    </body>

</html>
