<?php
// Database connection
$host = "localhost";      // your host (default: localhost)
$user = "root";           // default XAMPP user
$pass = "";               // default XAMPP password (empty)
$dbname = "shop_db"; // change this to your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
