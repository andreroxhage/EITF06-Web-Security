<?php 
// Code for locally connect to the database

$host = "localhost";
$dbname = "web_shop";
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password, $dbname);


if ($mysqli->connect_error) {
    die("". $mysqli->connect_error);
}

return $mysqli;
?>
