<?php
$servername = getenv('localhost');
$username = getenv('root');
$password = getenv('');
$dbname = getenv('budget_tracker');


$conn = new mysqli($servername, $username, $password, $dbname, 3306, null, MYSQLI_CLIENT_SSL);



if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
?>
