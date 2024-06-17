<?php
// Update these values with your actual database credentials
$servername = "lucidoserver.mysql.database.azure.com";
$username = "JC";
$password = "Jhared123";
$dbname = "budget_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
