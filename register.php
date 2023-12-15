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

// Handle user registration logic, including password hashing and database insertion

// Function to check if the signup rate limit is exceeded
function isSignupLimited() {
    $signup_attempts_key = 'signup_attempts_' . $_SERVER['REMOTE_ADDR'];
    $signup_attempts = isset($_SESSION[$signup_attempts_key]) ? $_SESSION[$signup_attempts_key] : 0;

    // Limit the number of sign-up attempts per minute
    $max_signup_attempts = 10;
    $signup_time_window = 600; // 10 minutes

    if ($signup_attempts >= $max_signup_attempts) {
        return true;
    }

    // Increment the sign-up attempts
    $_SESSION[$signup_attempts_key] = $signup_attempts + 1;

    // Set a timeout to reset the sign-up attempts after the time window
    $_SESSION['signup_timeout'] = time() + $signup_time_window;

    return false;
}


// Check if the sign-up rate limit is exceeded
if (isSignupLimited()) {
    die("Sign-up rate limit exceeded. Please try again later.");
}

// Server-side validation
// Check if password meets the minimum length requirement
if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

// Check if password contains at least one uppercase letter
if (!preg_match("/[A-Z]/", $_POST["password"])) {
    die("Password must contain at least one uppercase letter");
}

// Check if password contains at least one lowercase letter
if (!preg_match("/[a-z]/", $_POST["password"])) {
    die("Password must contain at least one lowercase letter");
}

// Check if password contains at least one number
if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

// Check if password contains at least one special character
if (!preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $_POST["password"])) {
    die("Password must contain at least one special character");
}

// Check against common password blacklist
$commonPasswords = [
    'Password1!', 'Qw123456789!', 'Qwerty123!', 'letmein123!', 'Admin123!',
    'Welcome1!', 'Pass1234!', 'abc12345', '123qwe', 'letmein123',
    'football1', 'qazwsx12', 'adminadmin', 'password123', 'Passw0rd!',
    '1234abcd', 'q1w2e3r4', '123abc', 'qwertyui', 'trustno1',
    'dragon12', 'iloveyou1', 'sunshine1', '123qweasd', 'qwerty123',
    'qwe12345', '1234qwer', 'password01', 'monkey12', 'test1234',
    'pass123', '123qweqwe', '12345qwe', 'Qw11111111!', 'iloveyou12',
    'welcome123', 'admin1234', 'pass12345', 'admin12', 'letmein1234',
    '123456a', 'asdf1234', '1qaz2wsx', 'qazwsx123', 'password12',
    '1234abcd', 'admin12345', 'letmein1', '1234qwer', '123456789a',
    'qwertyuiop', 'welcome12', 'passw0rd1', 'test123', '1234567890a',
    'q1w2e3r4t5', 'q1w2e3r4y5', '123456789q', 'qweasdzxc', 'qweqwe12',
    'qwerty12', '12345a', 'adminadmin1', 'a1b2c3d4', '123456789qwe',
    'abc12345', '123qweasdzxc', 'letmein12', '12345678910', 'password!',
    'qazxswedc', 'zxcvbnm1', 'password11', 'qazwsxedc1', 'qazwsx',
    '1234abcd1', '12345678a', '123123a', 'qweasdzxc', 'q1w2e3r4t5y6',
    '1234qwer1234', 'admin123456', 'q1w2e3r4t5u6', 'q1w2e3r4t5u6y7',
    'adminadmin12', 'q1w2e3r4t5y6u7', 'password1234', 'password12345',
    'password123456', 'password1234567', 'password12345678',
    'password123456789', 'password1234567890', 'q1w2e3r4t5u6y7i8',
    'q1w2e3r4t5u6y7i8o9', 'q1w2e3r4t5u6y7i8o9p0', 'password1234!',
    'password12345!', 'password123456!', 'password1234567!',
    'password12345678!', 'password123456789!', 'password1234567890!',
    'q1w2e3r4t5u6y7i8o9p0!', 'adminadmin123', 'adminadmin1234',
    'adminadmin12345', 'adminadmin123456', 'adminadmin1234567',
    'adminadmin12345678', 'adminadmin123456789', 'adminadmin1234567890'
];

if (in_array($password, $commonPasswords)) {
die("Common password detected. Please choose a more secure password.");
}

if( $_POST["password"] !== $_POST["password_confirmation"] ) {
die("Passwords must match");
}

// It is strongly recommended that you do not generate your own salt for this function. It will create a secure salt automatically for you if you do not specify one.

// As noted above, providing the salt option in PHP 7.0 will generate a deprecation warning. Support for providing a salt manually has been removed in PHP 8.0.
// Default cost is 10, our choosen cost is 12 meaning it takes longer time and resources to hash the password than the default function.

$password_hash = password_hash( $_POST["password"], PASSWORD_DEFAULT , ['cost' => 12]);

$mysqli = require __DIR__ . "/database.php"; // connect to database

$sql =
"INSERT INTO user (username, address, password_hash)
VALUES (?, ?, ?)"; // sql code for inserting a new user into the database table

$stmt = $mysqli->stmt_init();

// SQL prepare statement in order to avoid injection attacks
if( ! $stmt->prepare( $sql ) ) {
    die("SQL error: ". $mysqli->error);
}

$stmt->bind_param("sss", $_POST["username"],$_POST["address"],$password_hash); // sss means all three inputs are strings

// Redirect to appropriate page after registration
if( $stmt->execute() ) {
    header("Location: index.php");
    exit();
} else {
    if( $mysqli->errno === 1062) {
        die("Username already taken! Error nr.". $mysqli->errno);
    } else {
        die($mysqli-> error . " " . $mysqli->errno);
    }
}

?>
