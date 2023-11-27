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

// Handle user authentication logic, including password verification
// Redirect to appropriate page after authentication

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mysqli = require __DIR__ ."/database.php";
        
    /* 
    Vulnerable code with SQL injection vulnerability
    Scenario: database stores passwords in plain text    
    
    Insert
    username: a
    password:    ' or 1=1 --'
    
    a
    $2y$10$gFQoz1D.fyNqwWoDZhgZ1.EU5TEd/RC42B9/t10c5iUFzr5DjznvO
    
    c
    $2y$12$ifK62nJC33OHqb00DWGzuuBTZVjo95huLT/9Prlb3bbGiCD0Mlowy

    */
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $sql = "SELECT * FROM user WHERE username = '$username' AND (password_hash = '$password')";
    $result = $mysqli->query($sql);

    if($result) {
        $user = $result->fetch_assoc();
        session_start();
    
        if ($user) {
            session_regenerate_id(true); 
            $_SESSION["user_id"] = $user["id"];
            $is_invalid = true;
            $failed_attempts = 0; // Reset the failed attempt counter
            header("Location: index.php");
            exit;
        } else {
            // User not found
            $is_invalid = false;
        }  
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Login</title>
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

            <?php if ($is_invalid): ?>
            <p>Welcome back <b><?= htmlspecialchars($user["username"]) ?></b></p>

            <?php else: ?>

            <h2 id="login-h2">Login</h2>
            <form method="post" novalidate>
                <div id="login">
                    <?php if (isset($user) && !$is_invalid): ?>
                    <em>Invalid login</em>
                    <?php endif; ?>

                    <label for="username">Username:</label>
                    <input type="text" name="username" required>
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                    <input type="submit" value="Login">
                </div>
            </form>

            <?php endif; ?>

        </main>
        <footer>
            <p>&copy; 2023 Web Shop</p>
        </footer>
    </body>

</html>
