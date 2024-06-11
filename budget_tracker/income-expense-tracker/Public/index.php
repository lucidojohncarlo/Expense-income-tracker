<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income and Expense Tracker System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Style CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main">
    <div class="budget-container row">
        <div class="add-container col-md-4">
            <!-- Add Income Form -->
            <div class="add-income-container">
                <h4>Add Income</h4>
                <form id="incomeForm" action="add_income.php" method="POST">
                    <div class="form-group">
                        <label for="income">Income Source:</label>
                        <input class="form-control" type="text" id="income" name="income">
                    </div>
                    <div class="form-group">
                        <label for="incomeAmount">Amount:</label>
                        <input class="form-control" type="text" id="incomeAmount" name="incomeAmount">
                    </div>
                    <button class="btn btn-primary form-control" type="submit">Add Income</button>
                </form>
            </div>

            <!-- Add Expense Form -->
            <div class="add-expense-container mt-4">
                <h4>Add Expense</h4>
                <form id="expenseForm" action="add_expense.php" method="POST">
                    <div class="form-group">
                        <label for="expense">Expense Title:</label>
                        <input class="form-control" type="text" id="expense" name="expense">
                    </div>
                    <div class="form-group">
                        <label for="expenseAmount">Amount:</label>
                        <input class="form-control" type="text" id="expenseAmount" name="expenseAmount">
                    </div>
                    <button class="btn btn-primary form-control" type="submit">Add Expense</button>
                </form>
            </div>

            <!-- Reset All Button -->
            <button class="btn btn-danger form-control mt-2" onclick="resetAll()">Reset All</button>
        </div>

        <!-- Display Section -->
        <div class="display-container col-md-8">
            <div class="heading row" style="display: flex; justify-content: space-around;">
                <div class="alert alert-primary" role="alert">
                    Total Income: <span id="totalIncome">0</span>
                </div>
                <div class="alert alert-primary" role="alert">
                    Total Expenses: <span id="totalExpenses">0</span>
                </div>
                <div class="alert alert-primary" role="alert">
                    Balance: <span id="balance">0</span>
                </div>
            </div>
            <hr>
            <!-- Expense History Table -->
            <div class="table-container">
                <h5>Expense History:</h5>
                <div class="table-responsive" id="expenseHistoryContainer">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody id="expenseHistory">
                        <!-- Expense items will be added dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Audit Trail Section -->
            <div class="audit-trail mt-4">
                <h5>Audit Trail:</h5>
                <div class="audit-trail-container" id="auditTrailContainer">
                    <ul class="list-group" id="auditTrail">
                        <!-- Audit trail items will be added dynamically -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script JS -->
<script src="script.js"></script>
</body>
</html>
