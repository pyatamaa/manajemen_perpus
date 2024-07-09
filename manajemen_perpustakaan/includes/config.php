<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "manajemen_perpustakaan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function isLoggedIn() {
    return isset($_SESSION['username']);
}
?>
