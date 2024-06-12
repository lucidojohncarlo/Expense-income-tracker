<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expenseTitle = $_POST['expense'];
    $expenseAmount = $_POST['expenseAmount'];

    if (!empty($expenseTitle) && !empty($expenseAmount) && is_numeric($expenseAmount)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO expenses (title, amount) VALUES (?, ?)");
        $stmt->bind_param("sd", $expenseTitle, $expenseAmount);

        if ($stmt->execute()) {
            // Insert into audit trail
            $action = 'Add Expense';
            $details = "Title: $expenseTitle, Amount: ₱$expenseAmount";
            $stmt_audit = $conn->prepare("INSERT INTO audit_trail (action, details) VALUES (?, ?)");
            $stmt_audit->bind_param("ss", $action, $details);
            $stmt_audit->execute();
            $stmt_audit->close();

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
}
?>