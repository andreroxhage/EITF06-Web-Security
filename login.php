<?php
// Handle user authentication logic, including password verification
// Redirect to appropriate page after authentication

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mysqli = require __DIR__ ."/database.php";
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

            session_start();

            session_regenerate_id();    
            
            $_SESSION["user_id"] = $user["id"];
            header("Location: index.php");
            exit;
        }
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
