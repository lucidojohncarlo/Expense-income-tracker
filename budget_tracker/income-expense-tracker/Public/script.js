document.addEventListener("DOMContentLoaded", function () {
    // Function to add income
    function addIncome(incomeTitle, incomeAmount) {
        $.ajax({
            type: 'POST',
            url: 'add_income.php',
            data: { income: incomeTitle, incomeAmount: incomeAmount },
            success: function (response) {
                console.log(response);
                alert('Income added successfully');
                loadData(); // Reload data after successful insertion
            },
            error: function (error) {
                console.error(error);
                alert('Error adding income');
            }
        });
    }

    // Function to add expense
    function addExpense(expenseTitle, expenseAmount) {
        $.ajax({
            type: 'POST',
            url: 'add_expense.php',
            data: { expense: expenseTitle, expenseAmount: expenseAmount },
            success: function (response) {
                console.log(response);
                alert('Expense added successfully');
                loadData(); // Reload data after successful insertion
            },
            error: function (error) {
                console.error(error);
                alert('Error adding expense');
            }
        });
    }

    // Add income form submission
    document.getElementById('incomeForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const incomeTitle = document.getElementById('income').value;
        const incomeAmount = parseFloat(document.getElementById('incomeAmount').value);

        if (incomeTitle && !isNaN(incomeAmount)) {
            addIncome(incomeTitle, incomeAmount);

            document.getElementById('incomeForm').reset();
        } else {
            alert('Invalid input');
        }
    });

    // Add expense form submission
    document.getElementById('expenseForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const expenseTitle = document.getElementById('expense').value;
        const expenseAmount = parseFloat(document.getElementById('expenseAmount').value);

        if (expenseTitle && !isNaN(expenseAmount)) {
            addExpense(expenseTitle, expenseAmount);

            document.getElementById('expenseForm').reset();
        } else {
            alert('Invalid input');
        }
    });

    // Function to load data
    function loadData() {
        // Implement your logic to load data here
        // Example: Reload the page or update specific parts of the UI
        location.reload(); // Temporary solution to reload the page
    }

    // Other functions (editExpense, removeExpense) should be updated similarly to use AJAX calls and handle responses appropriately.

});

document.addEventListener("DOMContentLoaded", function () {
    // Initialize incomeData object
    let incomeData = {
        totalIncome: 0,
        totalExpenses: 0,
        balance: 0,
        expenses: [],
        auditTrail: []
    };

    // Function to update the UI with current incomeData
    function updateUI() {
        // Update total income, total expenses, and balance
        document.getElementById('totalIncome').textContent = `₱${incomeData.totalIncome.toFixed(2)}`;
        document.getElementById('totalExpenses').textContent = `₱${incomeData.totalExpenses.toFixed(2)}`;
        document.getElementById('balance').textContent = `₱${incomeData.balance.toFixed(2)}`;

        // Update expense history table
        let tableBody = document.getElementById('expenseHistory');
        tableBody.innerHTML = '';
        incomeData.expenses.forEach(function (expense, index) {
            let row = document.createElement('tr');
            row.innerHTML = `
                <td>${expense.title}</td>
                <td>₱${expense.amount.toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editExpense(${index})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="removeExpense(${index})">Remove</button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Update audit trail list
        let auditTrailList = document.getElementById('auditTrail');
        auditTrailList.innerHTML = '';
        incomeData.auditTrail.forEach(function (audit) {
            let listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.textContent = `₱ ${audit.message}`; // Include peso sign here
            auditTrailList.appendChild(listItem);
        });
    }

    // Function to reset all data
    window.resetAll = function () {
        $.ajax({
            type: 'POST',
            url: 'reset_data.php',
            success: function (response) {
                incomeData = JSON.parse(response);
                updateUI();
            },
            error: function () {
                alert('Error resetting data.');
            }
        });
    }

    // Load data from database
    function loadData() {
        $.ajax({
            type: 'GET',
            url: 'load_data.php',
            success: function (response) {
                incomeData = JSON.parse(response);
                updateUI();
            },
            error: function () {
                alert('Error loading data.');
            }
        });
    }

    loadData();

    // Add income
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
                    incomeData = JSON.parse(response);
                    updateUI();
                },
                error: function () {
                    alert('Error adding income.');
                }
            });

            document.getElementById('incomeForm').reset();
        }
    });

    // Add expense
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
                    console.log(response);
                    incomeData = JSON.parse(response);
                    updateUI();
                },
                error: function () {
                    alert('Error adding expense.');
                }
            });

            document.getElementById('expenseForm').reset();
        }
    });

    // Edit expense
    window.editExpense = function (index) {
        const expense = incomeData.expenses[index];
        const newTitle = prompt("Edit expense title:", expense.title);
        const newAmount = parseFloat(prompt("Edit expense amount:", expense.amount));

        if (newTitle && !isNaN(newAmount)) {
            $.ajax({
                type: 'POST',
                url: 'edit_expense.php',
                data: {
                    index: index,
                    title: newTitle,
                    amount: newAmount,
                },
                success: function (response) {
                    console.log(response);
                    incomeData = JSON.parse(response);
                    updateUI();
                },
                error: function () {
                    alert('Error editing expense.');
                }
            });
        }
    }

    // Remove expense
    window.removeExpense = function (index) {
        if (confirm("Are you sure you want to remove this expense?")) {
            $.ajax({
                type: 'POST',
                url: 'remove_expense.php',
                data: {
                    index: index
                },
                success: function (response) {
                    console.log(response);
                    incomeData = JSON.parse(response);
                    updateUI();
                },
                error: function () {
                    alert('Error removing expense.');
                }
            });
        }
    }
});

               
