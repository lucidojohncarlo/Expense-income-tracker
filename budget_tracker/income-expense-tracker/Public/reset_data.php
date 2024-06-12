<?php
include 'db_connect.php';

// Reset all data
$incomeData = array(
    'totalIncome' => 0,
    'totalExpenses' => 0,
    'balance' => 0,
    'expenses' => [],
    'auditTrail' => []
);

// Store income data in localStorage
echo json_encode($incomeData);

// Clear all tables
$sql = "TRUNCATE TABLE income";
$conn->query($sql);

$sql = "TRUNCATE TABLE expenses";
$conn->query($sql);

$sql = "TRUNCATE TABLE audit_trail";
$conn->query($sql);

$conn->close();
?>
