<?php
require 'db_connect.php';

// Clear all tables
$conn->query("TRUNCATE TABLE income");
$conn->query("TRUNCATE TABLE expenses");
$conn->query("TRUNCATE TABLE audit_trail");

$message = "Reset all data";
$conn->query("INSERT INTO audit_trail (message) VALUES ('$message')");

$conn->close();

// Reload data after operation
require 'load_data.php';
?>
