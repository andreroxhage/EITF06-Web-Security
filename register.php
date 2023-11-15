<?php
// Handle user registration logic, including password hashing and database insertion

// Server-side validation
if ( empty( $_POST["username"] ) ) {
    die("Username is required!"); 
}

if ( empty( $_POST["address"] ) ) {
    die("Valid address is required"); 
}

if (strlen( $_POST["password"] ) < 8) {
    die("Password must be at least 8 characters");
}

if( !preg_match("/[a-z]/i", $_POST["password"] ) ) {
    die("Password must contain at least one letter");
}

if( !preg_match("/[0-9]/i", $_POST["password"] ) ) {
    die("Password must contain at least one number");
}

if( $_POST["password"] !== $_POST["password_confirmation"] ) {
    die("Passwords must match");
}

// TO-DO add salt to hash of psw
// It is strongly recommended that you do not generate your own salt for this function. It will create a secure salt automatically for you if you do not specify one.
As noted above, providing the salt option in PHP 7.0 will generate a deprecation warning. Support for providing a salt manually has been removed in PHP 8.0.

$password_hash = password_hash( $_POST["password"], PASSWORD_DEFAULT );

$mysqli = require __DIR__ . "/database.php"; // connect to database

$sql = 
"INSERT INTO user (username, address, password_hash)
VALUES (?, ?, ?)"; // sql code for inserting a new user into the database table

$stmt =  $mysqli->stmt_init();

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
