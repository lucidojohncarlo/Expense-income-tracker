<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $index = $_POST['index'];

    if (!empty($index) && is_numeric($index)) {
        // Get expense details
        $sql = "SELECT * FROM expenses WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $index);
        $stmt->execute();
        $result = $stmt->get_result();
        $expense = $result->fetch_assoc();
        $stmt->close();

        // Delete expense
        $sql = "DELETE FROM expenses WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $index);
        $stmt->execute();
        $stmt->close();

        // Update total expenses and balance
        $amount = $expense['amount'];
        $sql = "UPDATE income SET amount = amount - ? WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("d", $amount);
        $stmt->execute();
        $stmt->close();

        // Insert into audit trail
        $action = 'Remove Expense';
        $details = "Title: {$expense['title']}, Amount: ₱{$expense['amount']}";
        $stmt = $conn->prepare("INSERT INTO audit_trail (action, details) VALUES (?, ?)");
        $stmt->bind_param("ss", $action, $details);
        $stmt->execute();
        $stmt->close();

        // Load updated data
        include 'load_data.php';
        echo json_encode($incomeData);
    } else {
        echo "Invalid input.";
    }

    $conn->close();
}
?>
