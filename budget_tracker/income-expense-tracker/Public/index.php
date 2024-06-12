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
                <form id="incomeForm" method="POST">
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
                <form id="expenseForm" method="POST">
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
                    Total Income: <span id="totalIncome">₱<?= $incomeData['totalIncome'] ?></span>
                </div>
                <div class="alert alert-primary" role="alert">
                    Total Expenses: <span id="totalExpenses">₱<?= $incomeData['totalExpenses'] ?></span>
                </div>
                <div class="alert alert-primary" role="alert">
                    Balance: <span id="balance">₱<?= $incomeData['balance'] ?></span>
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
                        <?php foreach ($incomeData['expenses'] as $expense): ?>
                            <tr>
                                <td><?= $expense['title'] ?></td>
                                <td>₱<?= $expense['amount'] ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editExpense(<?= $expense['id'] ?>)">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="removeExpense(<?= $expense['id'] ?>)">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Audit Trail Section -->
            <div class="audit-trail mt-4">
                <h5>Audit Trail:</h5>
                <div class="audit-trail-container" id="auditTrailContainer">
                    <ul class="list-group" id="auditTrail">
                        <?php foreach ($incomeData['auditTrail'] as $audit): ?>
                            <li class="list-group-item"><?= $audit['message'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script JS -->
<script src="script.js"></script>

<script>
    // Function to reset all data
    function resetAll() {
        $.ajax({
            type: 'POST',
            url: 'reset_data.php',
            success: function (response) {
                const data = JSON.parse(response);
                updateUI(data);
            },
            error: function () {
                alert('Error resetting data.');
            }
        });
    }

    // Edit expense
    function editExpense(id) {
        const newTitle = prompt("Edit expense title:");
        const newAmount = parseFloat(prompt("Edit expense amount:"));

        if (newTitle && !isNaN(newAmount)) {
            $.ajax({
                type: 'POST',
                url: 'edit_expense.php',
                data: {
                    id: id,
                    title: newTitle,
                    amount: newAmount
                },
                success: function (response) {
                    const data = JSON.parse(response);
                    updateUI(data);
                },
                error: function () {
                    alert('Error editing expense.');
                }
            });
        }
    }

    // Remove expense
    function removeExpense(id) {
        if (confirm("Are you sure you want to remove this expense?")) {
            $.ajax({
                type: 'POST',
                url: 'remove_expense.php',
                data: {
                    id: id
                },
                success: function (response) {
                    const data = JSON.parse(response);
                    updateUI(data);
                },
                error: function () {
                    alert('Error removing expense.');
                }
            });
        }
    }

    // Function to update the UI with current data
    function updateUI(data) {
        // Update total income, total expenses, and balance
        document.getElementById('totalIncome').textContent = `₱${data.totalIncome.toFixed(2)}`;
        document.getElementById('totalExpenses').textContent = `₱${data.totalExpenses.toFixed(2)}`;
        document.getElementById('balance').textContent = `₱${data.balance.toFixed(2)}`;

        // Update expense history table
        let tableBody = document.getElementById('expenseHistory');
        tableBody.innerHTML = '';
        data.expenses.forEach(function (expense) {
            let row = document.createElement('tr');
            row.innerHTML = `
                <td>${expense.title}</td>
                <td>₱${expense.amount.toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editExpense(${expense.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="removeExpense(${expense.id})">Remove</button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Update audit trail list
        let auditTrailList = document.getElementById('auditTrail');
        auditTrailList.innerHTML = '';
        data.auditTrail.forEach(function (audit) {
            let listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.textContent = `${audit.message}`; // Include peso sign here
            auditTrailList.appendChild(listItem);
        });
    }

    // Add income form submission
    document.getElementById('incomeForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const incomeTitle = document.getElementById('income').value;
        const incomeAmount = parseFloat(document.getElementById('incomeAmount').value);

        if (incomeTitle && !isNaN(incomeAmount)) {
            $.ajax({
                type: 'POST',
                url: 'add_income.php',
                data: {
                    income: incomeTitle,
                    incomeAmount: incomeAmount
                },
                success: function (response) {
                    console.log(response);
                    const data = JSON.parse(response);
                    updateUI(data);
                },
                error: function () {
                    alert('Error adding income.');
                }
            });

            document.getElementById('incomeForm').reset
        }

        document.getElementById('incomeForm').reset();
    });

    // Add expense form submission
    document.getElementById('expenseForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const expenseTitle = document.getElementById('expense').value;
        const expenseAmount = parseFloat(document.getElementById('expenseAmount').value);

        if (expenseTitle && !isNaN(expenseAmount)) {
            $.ajax({
                type: 'POST',
                url: 'add_expense.php',
                data: {
                    expense: expenseTitle,
                    expenseAmount: expenseAmount
                },
                success: function (response) {
                    const data = JSON.parse(response);
                    updateUI(data);
                },
                error: function () {
                    alert('Error adding expense.');
                }
            });

            document.getElementById('expenseForm').reset();
        }
    });
</script>

</body>
</html>