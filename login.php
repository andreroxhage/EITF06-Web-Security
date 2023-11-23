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

// If aleady logged in set user details
if (isset($_SESSION["user_id"])) {  
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}

// Handle user authentication logic, including password verification
// Redirect to appropriate page after authentication

$is_invalid = false;
$max_attempts = 3; // Log in attempts per session
$lockout_duration = 300; // 5 minutes in seconds
$max_lockout_duration = 1800; // 30 minutes

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mysqli = require __DIR__ ."/database.php";
        
    // Use prepared statement for the login query
    $sql  = sprintf(
        "SELECT *
        FROM user
        WHERE username = '%s'",
        $mysqli->real_escape_string($_POST["username"])
    ); // real escape prevents SQL injections

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    // Successful login:
    //regenerate_id = Prevents session fixation attacks: deletes previous session id and generates a new one, while keeping the session variables    
    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {
            session_regenerate_id(true); 
            $_SESSION["user_id"] = $user["id"];
            $is_invalid = true;
            $failed_attempts = 0; // Reset the failed attempt counter
            header("Location: index.php");
            exit;
        } else{
            $is_invalid = false;
        }
    }

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
    
    if(isset($_SESSION["lockout_time"]) && time() - $_SESSION['lockout_time'] < $lockout_duration){
        die("You are currently locked out. Please try again later.");
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
