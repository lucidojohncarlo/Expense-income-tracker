<?php
// Update these values with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "budget_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
