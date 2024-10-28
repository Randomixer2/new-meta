<?php
$host = 'localhost';
$user = 'root'; // Update with your database username
$password = ''; // Update with your database password
$database = 'user_management'; // Update with your database name

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
