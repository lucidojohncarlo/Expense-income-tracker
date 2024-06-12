<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $incomeTitle = $_POST['income'];
    $incomeAmount = $_POST['incomeAmount'];

    if (!empty($incomeTitle) && !empty($incomeAmount) && is_numeric($incomeAmount)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO incomes (title, amount) VALUES (?, ?)");
        $stmt->bind_param("sd", $incomeTitle, $incomeAmount);

        if ($stmt->execute()) {
            // Insert into audit trail
            $action = 'Add Income';
            $details = "Title: $incomeTitle, Amount: ₱$incomeAmount";
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