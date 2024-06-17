<?php
$servername = getenv('DB_SERVER');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');


$conn = new mysqli($servername, $username, $password, $dbname, 3306, null, MYSQLI_CLIENT_SSL);



if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
?>
