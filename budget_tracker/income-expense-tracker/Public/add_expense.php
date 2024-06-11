<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['expense'];
    $amount = $_POST['expenseAmount'];

    if (!empty($title) && !empty($amount) && is_numeric($amount)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO expenses (title, amount) VALUES (?, ?)");
        $stmt->bind_param("sd", $title, $amount);

        if ($stmt->execute()) {
            echo "New expense record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid input.";
    }

    $conn->close();
    header("Location: index.php");
    exit();
}
?>
