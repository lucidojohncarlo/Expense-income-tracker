<?php
require 'db_connect.php';

$income = $_POST['income'];
$incomeAmount = $_POST['incomeAmount'];

$stmt = $conn->prepare("INSERT INTO income (source, amount) VALUES (?, ?)");
$stmt->bind_param("sd", $income, $incomeAmount);
$stmt->execute();

$message = "Added income: $income - ₱$incomeAmount";
$conn->query("INSERT INTO audit_trail (message) VALUES ('$message')");

$stmt->close();
$conn->close();

// Reload data after operation
require 'load_data.php';
?>
