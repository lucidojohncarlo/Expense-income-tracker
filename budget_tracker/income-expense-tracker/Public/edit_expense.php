<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $index = $_POST['index'];
    $title = $_POST['title'];
    $amount = $_POST['amount'];

    if (!empty($index) && is_numeric($index) && !empty($title) && !empty($amount) && is_numeric($amount)) {
        // Get old expense amount
        $sql = "SELECT amount FROM expenses WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $index);
        $stmt->execute();
        $stmt->bind_result($oldAmount);
        $stmt->fetch();
        $stmt->close();

        // Prepare and bind
        $stmt = $conn->prepare("UPDATE expenses SET title = ?, amount = ? WHERE id = ?");
        $stmt->bind_param("sdi", $title, $amount, $index);

        if ($stmt->execute()) {
            // Update total expenses and balance
            $difference = $amount - $oldAmount;
            $sql = "UPDATE income SET amount = amount + ? WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("d", $difference);
            $stmt->execute();
            $stmt->close();

            // Insert into audit trail
            $action = 'Edit Expense';
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
