<?php
// Update these values with your actual database credentials
<<<<<<< HEAD
//$servername = getenv("DB_Server");
//$username = getenv("DB_Username");
//$password = getenv("DB_Password");
//$dbname = getenv("DB_Database");
=======
$servername = getenv('DB_Server');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');
>>>>>>> origin/main


<<<<<<< HEAD
//$servername ="localhost" ;
//$username = "root";
//$password = "";
//$dbname = "budget_tracker";

// Create connection with SSL
//$conn = new mysqli($servername, $username, $password, $dbname, 3306, NULL, MYSQLI_CLIENT_SSL);
=======
// $servername ="jcserver.mysql.database.azure.com" ;
// $username = "johncarlo";
// $password = "Jhared123";
// $dbname = "budget_tracker";

// $servername ="localhost" ;
// $username = "root";
// $password = "";
// $dbname = "budget_tracker";

// Create connection with SSL
// $conn = new mysqli($servername, $username, $password, $dbname, 3306, NULL, MYSQLI_CLIENT_SSL);

>>>>>>> origin/main

//$conn = new mysqli($servername, $username, $password, $dbname);

// $conn = mysqli_init();
// mysqli_ssl_set($conn, NULL, NULL, "C:\Users\lucidojm\Downloads", NULL, NULL);
// mysqli_real_connect($conn, $server, $username, $password, $database, $port, NULL, MYSQLI_CLIENT_SSL);


// $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
