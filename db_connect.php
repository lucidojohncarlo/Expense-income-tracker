<?php
// Update these values with your actual database credentials
$servername = getenv('DB_Server');
$username = getenv('DB_Username');
$password = getenv('DB_Password');
$dbname = getenv('DB_Database');

// $servername ="jcserver.mysql.database.azure.com" ;
// $username = "johncarlo";
// $password = "Jhared123";
// $dbname = "budget_tracker";

// $servername ="localhost" ;
// $username = "root";
// $password = "";
// $dbname = "budget_tracker";

// SSL configuration (optional, uncomment if needed)
// $ssl_ca = '/path/to/ca-cert.pem'; // Update with the path to your CA certificate

// Create connection with SSL
// SSL configuration (uncomment if you have a CA certificate)
// $use_ssl = false; // Change to true if you have SSL certificate
// if ($use_ssl) {
//     mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);
// }


//$conn = mysqli_init();
//$ssl_ca = 'D:\DOWNLOADS\Cert\DigiCertGlobalRootCA.crt.pem'; // Update with the correct path
//mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);
//
//if (!mysqli_real_connect($conn, $servername, $username, $password, $dbname)) {
//    die("Connection failed: " . mysqli_connect_error());
//} else {
//    echo "Connected successfully!";
//}
//
//$conn->close();

//
//
//$port = 3306; // Default MySQL port
//$flags = 0; // MYSQLI_CLIENT_SSL; // Uncomment if using SSL
//
//if (!$conn) {
//    die("mysqli_init failed");
//}
//
//if (!mysqli_real_connect($conn, $servername, $username, $password, $dbname, $port, NULL, $flags)) {
//    die("Connection failed: " . mysqli_connect_error());
//}
//
//echo "Connected successfully!";

$conn = new mysqli($servername, $username, $password, $dbname);

// $conn = new mysqli($servername, $username, $password, $dbname, 3306, NULL, MYSQLI_CLIENT_SSL);

//$conn = mysqli_init();
//mysqli_ssl_set($conn, NULL, NULL, "C:\Users\lucidojm\Downloads", NULL, NULL);
//mysqli_real_connect($conn, $server, $username, $password, $database, $port, NULL, MYSQLI_CLIENT_SSL);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Optional: Set charset
//$conn->set_charset("utf8mb4");

// Return the connection object for use in other scripts
return $conn;
?>
