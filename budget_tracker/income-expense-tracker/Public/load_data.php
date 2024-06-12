<?php
include 'db_connect.php';

// Load all data
$incomeData = array(
    'totalIncome' => 0,
    'totalExpenses' => 0,
    'balance' => 0,
    'expenses' => [],
    'auditTrail' => []
);

// Fetch total income
$sql = "SELECT SUM(amount) AS totalIncome FROM income";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $incomeData['totalIncome'] = (float)$row['totalIncome'];
}

// Fetch total expenses
$sql = "SELECT SUM(amount) AS totalExpenses FROM expenses";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $incomeData['totalExpenses'] = (float)$row['totalExpenses'];
}

// Calculate balance
$incomeData['balance'] = $incomeData['totalIncome'] - $incomeData['totalExpenses'];

// Fetch expenses
$sql = "SELECT * FROM expenses";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $incomeData['expenses'][] = array(
            'title' => $row['title'],
            'amount' => (float)$row['amount']
        );
    }
}

// Fetch audit trail
$sql = "SELECT * FROM audit_trail ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $incomeData['auditTrail'][] = array(
            'action' => $row['action'],
            'details' => $row['details']
        );
    }
}

echo json_encode($incomeData);

$conn->close();
?>
