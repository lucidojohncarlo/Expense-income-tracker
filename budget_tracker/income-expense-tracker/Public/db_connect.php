<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$database = "income_expense_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
