<?php
$servername = "localhost";
$username = "root";  // Default username for MySQL in XAMPP
$password = "";  // Default password for MySQL in XAMPP is empty
$dbname = "blood donation";  // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
