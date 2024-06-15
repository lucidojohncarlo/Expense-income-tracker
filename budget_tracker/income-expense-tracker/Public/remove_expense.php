<?php
require 'db_connect.php';

$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$message = "Removed expense ID $id";
$conn->query("INSERT INTO audit_trail (message) VALUES ('$message')");

$stmt->close();
$conn->close();

require 'load_data.php';
?>
