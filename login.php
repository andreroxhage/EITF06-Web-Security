<?php
session_start();

// Handle user authentication logic, including password verification
// Redirect to appropriate page after authentication

$is_invalid = false;
$max_attempts = 3; // Log in attempts per session
$lockout_duration = 300; // 5 minutes in seconds
$max_lockout_duration = 1800; // 30 minutes

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mysqli = require __DIR__ ."/database.php";

    // Log the failed login attempts. Creates failed attemps session variable based on IP
    $failed_attempts_key = 'failed_login_attempts_' . $_SERVER['REMOTE_ADDR']; 
    $failed_attempts = isset($_SESSION[$failed_attempts_key]) ? $_SESSION[$failed_attempts_key] : 0;
    $failed_attempts++;

    // Lockout user based on number of failed login attempts. Uses session variable to keep track of attempts based on IP
    $_SESSION[$failed_attempts_key] = $failed_attempts; 

    // Gradually increase the lockout time. However it wont exeed the maximum duration.
    if ($failed_attempts >= $max_attempts) {
        $new_lockout_duration = min($lockout_duration * 2, $max_lockout_duration);
        
        $_SESSION['lockout_time'] = time();
        $_SESSION['lockout_duration'] = $new_lockout_duration;
        die("You are temporarily locked out. Please try again later.");
    }
    
    $sql  = sprintf(
        "SELECT *
        FROM user
        WHERE username = '%s'",
        $mysqli->real_escape_string($_POST["username"])
    ); // real escape prevents SQL injections

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {
            session_regenerate_id();    
            $_SESSION["user_id"] = $user["id"];
            header("Location: index.php");
            exit;
        }
    }
    
    if(isset($_SESSION["lockout_time"]) && time() - $_SESSION['lockout_time'] < $lockout_duration){
        die("You are currently locked out. Please try again later.");
    }

    $is_invalid = true;
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
            <h2 id="login-h2">Login</h2>
            <form method="post" novalidate>
                <div id="login">
                    <?php if ($is_invalid): ?>
                    <em>Invalid login</em>
                    <?php endif; ?>

                    <label for="username">Username:</label>
                    <input type="text" name="username" required>
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                    <input type="submit" value="Login">
                </div>
            </form>
        </main>
        <footer>
            <p>&copy; 2023 Web Shop</p>
        </footer>
    </body>

</html>
