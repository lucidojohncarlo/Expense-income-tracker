<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expenseId = $_POST['id'];

    if (!empty($expenseId)) {
        // Delete expense
        $stmt = $conn->prepare("DELETE FROM expenses WHERE id=?");
        $stmt->bind_param("i", $expenseId);

        if ($stmt->execute()) {
            // Insert into audit trail
            $action = 'Remove Expense';
            $details = "ID: $expenseId";
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
