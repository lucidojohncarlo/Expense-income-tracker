<?php
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "budget_tracker"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname, 3306, null, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
