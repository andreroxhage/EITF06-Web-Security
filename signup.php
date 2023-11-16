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
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Sign Up</title>
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
            <h2 id="signup-h2">Sign Up</h2>
            <form action="register.php" method="post" novalidate>
                <div id="signup">
                    <label for="username">Username:</label>
                    <input type="text" name="username" required>

                    <label for="address">Address:</label>
                    <input type="text" name="address" required>

                    <label for="password">Password:</label>
                    <input type="password" name="password" required>

                    <label for="password_confirmation">Repeat Password:</label>
                    <input type="password" name="password_confirmation" required>

                    <p>Password must:</p>
                    <ul>
                        <li>Be at least 8 characters</li>
                        <li>Contain at least one uppercase letter</li>
                        <li>Contain at least one lowercase letter</li>
                        <li>Contain at least one number</li>
                        <li>Contain at least one special character (e.g., !@#$%^&*())</li>
                    </ul>

                    <input type="submit" value="Sign Up">
                </div>
            </form>
        </main>
        <footer>
            <p>&copy; 2023 Web Shop</p>
        </footer>
    </body>

</html>
