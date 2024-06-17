<?php
// Update these values with your actual database credentials
$servername = getenv('DB_Server');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// SSL configuration (optional, uncomment if needed)
 $ssl_ca = 'D:\DOWNLOADS\Cert'; // Update with the path to your CA certificate

// Create connection
$conn = mysqli_init();

// SSL configuration (uncomment if you have a CA certificate)
$use_ssl = false; // Change to true if you have SSL certificate
if ($use_ssl) {
    $ssl_ca = 'D:\DOWNLOADS\Cert'; // Update with the actual path to your CA certificate
    mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);
}

// Establish connection
$port = 3306; // Default MySQL port
$flags = $use_ssl ? MYSQLI_CLIENT_SSL : 0; // Use SSL flag if SSL is enabled

if (!mysqli_real_connect($conn, $servername, $username, $password, $dbname, $port, NULL, $flags)) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully!";
?>
