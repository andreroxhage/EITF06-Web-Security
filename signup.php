<?php
session_start();
?>

<?php
// Echo session variables that were set on index page
echo "Favorite color is " . $_SESSION["favcolor"] . ".<br>";
echo "Favorite animal is " . $_SESSION["favanimal"] . ".";
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

                    <input type="submit" value="Sign Up">
                </div>
            </form>
        </main>
        <footer>
            <p>&copy; 2023 Web Shop</p>
        </footer>
    </body>

</html>
