<?php
// Database connection
$conn = new mysqli(getenv('DB_Server'), getenv('DB_Username'), getenv('DB_Password'), getenv('DB_Database'));

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize response array
$response = ["status" => "", "message" => "", "data" => []];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == "add_income") {
            $income = $_POST['income'];
            $incomeAmount = $_POST['incomeAmount'];

            $stmt = $conn->prepare("INSERT INTO income (source, amount) VALUES (?, ?)");
            $stmt->bind_param("ss", $income, $incomeAmount);

            if ($stmt->execute()) {
                $response["status"] = "success";
                $response["message"] = "Income added successfully!";
            } else {
                $response["status"] = "error";
                $response["message"] = "Error adding income!";
            }
            $stmt->close();
        } elseif ($action == "add_expense") {
            $expense = $_POST['expense'];
            $expenseAmount = $_POST['expenseAmount'];

            $stmt = $conn->prepare("INSERT INTO expenses (title, amount) VALUES (?, ?)");
            $stmt->bind_param("ss", $expense, $expenseAmount);

            if ($stmt->execute()) {
                $response["status"] = "success";
                $response["message"] = "Expense added successfully!";
            } else {
                $response["status"] = "error";
                $response["message"] = "Error adding expense!";
            }
            $stmt->close();
        } elseif ($action == "reset") {
            // Reset all data
            $conn->query("TRUNCATE TABLE income");
            $conn->query("TRUNCATE TABLE expenses");
            $response["status"] = "success";
            $response["message"] = "All data reset successfully!";
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch data for display
    $resultIncome = $conn->query("SELECT SUM(amount) as totalIncome FROM income");
    $totalIncome = $resultIncome->fetch_assoc()["totalIncome"] ?? 0;

    $resultExpenses = $conn->query("SELECT SUM(amount) as totalExpenses FROM expenses");
    $totalExpenses = $resultExpenses->fetch_assoc()["totalExpenses"] ?? 0;

    $balance = $totalIncome - $totalExpenses;

    $expenseHistory = [];
    $result = $conn->query("SELECT id, title, amount FROM expenses");
    while ($row = $result->fetch_assoc()) {
        $expenseHistory[] = $row;
    }

    $response["data"] = [
        "totalIncome" => $totalIncome,
        "totalExpenses" => $totalExpenses,
        "balance" => $balance,
        "expenseHistory" => $expenseHistory
    ];
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
