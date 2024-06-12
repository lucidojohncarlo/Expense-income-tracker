<?php
include 'db_connect.php';

// Function to fetch data from database
function loadData() {
    global $conn;

    // Fetch total income
    $totalIncomeQuery = $conn->query("SELECT SUM(amount) AS totalIncome FROM incomes");
    $totalIncome = $totalIncomeQuery->fetch_assoc();
    $totalIncomeAmount = (float) $totalIncome['totalIncome'];

    // Fetch total expenses
    $totalExpensesQuery = $conn->query("SELECT SUM(amount) AS totalExpenses FROM expenses");
    $totalExpenses = $totalExpensesQuery->fetch_assoc();
    $totalExpensesAmount = (float) $totalExpenses['totalExpenses'];

    // Calculate balance
    $balance = $totalIncomeAmount - $totalExpensesAmount;

    // Fetch expense history
    $expensesQuery = $conn->query("SELECT * FROM expenses ORDER BY id DESC");
    $expenses = [];
    while ($row = $expensesQuery->fetch_assoc()) {
        $expenses[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'amount' => (float) $row['amount']
        ];
    }

    // Fetch audit trail
    $auditTrailQuery = $conn->query("SELECT * FROM audit_trail ORDER BY id DESC");
    $auditTrail = [];
    while ($row = $auditTrailQuery->fetch_assoc()) {
        $auditTrail[] = [
            'id' => $row['id'],
            'message' => $row['action'] . ' - ' . $row['details']
        ];
    }

    return [
        'totalIncome' => $totalIncomeAmount,
        'totalExpenses' => $totalExpensesAmount,
        'balance' => $balance,
        'expenses' => $expenses,
        'auditTrail' => $auditTrail
    ];
}

// Load data
$incomeData = loadData();
?>
