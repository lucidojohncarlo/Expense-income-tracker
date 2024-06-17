<?php
require 'db_connect.php';

$id = $_POST['id'];
$title = $_POST['title'];
$amount = $_POST['amount'];

$stmt = $conn->prepare("UPDATE expenses SET title = ?, amount = ? WHERE id = ?");
$stmt->bind_param("sdi", $title, $amount, $id);
$stmt->execute();

$message = "Edited expense ID $id: $title - ₱$amount";
$conn->query("INSERT INTO audit_trail (message) VALUES ('$message')");

$stmt->close();
$conn->close();

// Reload data after operation
require 'load_data.php';
?>
