<?php
// Update these values with your actual database credentials
$servername = getenv("DB_Server");
$username = getenv("DB_Username");
$password = getenv("DB_Password");
$dbname = getenv("DB_Database");

//$servername ="localhost" ;
//$username = "root";
//$password = "";
//$dbname = "budget_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
