<?php
include 'db_connect.php';

// Reset all data
$reset_incomes = $conn->query("DELETE FROM incomes");
$reset_expenses = $conn->query("DELETE FROM expenses");
$reset_audit_trail = $conn->query("DELETE FROM audit_trail");

if ($reset_incomes && $reset_expenses && $reset_audit_trail) {
    // Load updated data
    include 'load_data.php';
    echo json_encode($incomeData);
} else {
    echo "Error: Reset failed.";
}
?>
