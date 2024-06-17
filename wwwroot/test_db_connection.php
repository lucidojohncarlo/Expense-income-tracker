<?php
$servername = getenv("DB_Server");
$username = getenv("DB_Username");
$password = getenv("DB_Password");
$dbname = getenv("DB_Database");

// Create connection with SSL
$conn = new mysqli($servername, $username, $password, $dbname, 3306, NULL, MYSQLI_CLIENT_SSL);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
