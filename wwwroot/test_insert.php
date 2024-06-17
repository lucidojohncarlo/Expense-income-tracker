<?php
include 'db_connect.php';

$source = 'Test Income';
$amount = 100.00;

$stmt = $conn->prepare("INSERT INTO income (source, amount) VALUES (?, ?)");
$stmt->bind_param("sd", $source, $amount);

if ($stmt->execute()) {
    echo "Test income record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
