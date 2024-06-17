<?php
// Update these values with your actual database credentials
$servername = getenv('DB_Server');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// SSL configuration (optional, uncomment if needed)
// $ssl_ca = 'path_to_ca_cert'; // Update with the path to your CA certificate

// Create connection
$conn = mysqli_init();

// SSL configuration (uncomment if you have a CA certificate)
// mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);

mysqli_real_connect($conn, $servername, $username, $password, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully!";
?>
