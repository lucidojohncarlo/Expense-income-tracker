<?php
require 'db_connect.php';

$totalIncome = 0;
$totalExpenses = 0;

$incomeResult = $conn->query("SELECT SUM(amount) AS total FROM income");
if ($incomeResult->num_rows > 0) {
    $row = $incomeResult->fetch_assoc();
    $totalIncome = $row['total'] ? $row['total'] : 0;
}

$expensesResult = $conn->query("SELECT SUM(amount) AS total FROM expenses");
if ($expensesResult->num_rows > 0) {
    $row = $expensesResult->fetch_assoc();
    $totalExpenses = $row['total'] ? $row['total'] : 0;
}

$balance = $totalIncome - $totalExpenses;

$expensesData = [];
$expensesResult = $conn->query("SELECT * FROM expenses");
while ($row = $expensesResult->fetch_assoc()) {
    $expensesData[] = $row;
}

$auditTrailData = [];
$auditTrailResult = $conn->query("SELECT * FROM audit_trail ORDER BY created_at DESC");
while ($row = $auditTrailResult->fetch_assoc()) {
    $auditTrailData[] = $row;
}

$response = [
    'totalIncome' => $totalIncome,
    'totalExpenses' => $totalExpenses,
    'balance' => $balance,
    'expenses' => $expensesData,
    'auditTrail' => $auditTrailData
];

echo json_encode($response);

$conn->close();
?>
