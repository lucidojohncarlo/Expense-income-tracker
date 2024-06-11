<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $source = $_POST['income'];
    $amount = $_POST['incomeAmount'];

    if (!empty($source) && !empty($amount) && is_numeric($amount)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO income (source, amount) VALUES (?, ?)");
        $stmt->bind_param("sd", $source, $amount);

        if ($stmt->execute()) {
            echo "New income record created successfully";
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
