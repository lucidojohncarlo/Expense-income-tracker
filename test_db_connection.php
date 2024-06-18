<?php
$servername = getenv('DB_Server');
$username = getenv('DB_Username');
$password = getenv('DB_Password');
$dbname = getenv('DB_Database');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}

$conn->close();
?>
