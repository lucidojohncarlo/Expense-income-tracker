<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$database = "income_expense_tracker";


// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO expenses (title, amount) VALUES (?, ?)");
$stmt->bind_param("sd", $title, $amount);

$title = $_POST['expense'];
$amount = $_POST['expenseAmount'];

if ($stmt->execute()) {
    echo "New expense record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: index.php");
exit();
?>
