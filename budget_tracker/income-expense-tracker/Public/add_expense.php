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
            // Insert into audit trail
            $action = 'Add Expense';
            $details = "Title: $title, Amount: ₱$amount";
            $stmt = $conn->prepare("INSERT INTO audit_trail (action, details) VALUES (?, ?)");
            $stmt->bind_param("ss", $action, $details);
            $stmt->execute();
            $stmt->close();

            // Load updated data
            include 'load_data.php';
            echo json_encode($incomeData);
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid input.";
    }

    $conn->close();
}
?>
