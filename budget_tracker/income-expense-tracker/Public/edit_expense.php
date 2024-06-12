<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expenseId = $_POST['id'];
    $newTitle = $_POST['title'];
    $newAmount = $_POST['amount'];

    if (!empty($expenseId) && !empty($newTitle) && !empty($newAmount) && is_numeric($newAmount)) {
        // Update expense
        $stmt = $conn->prepare("UPDATE expenses SET title=?, amount=? WHERE id=?");
        $stmt->bind_param("sdi", $newTitle, $newAmount, $expenseId);

        if ($stmt->execute()) {
            // Insert into audit trail
            $action = 'Edit Expense';
            $details = "ID: $expenseId, New Title: $newTitle, New Amount: ₱$newAmount";
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
