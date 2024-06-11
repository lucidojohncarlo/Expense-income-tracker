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
        document.getElementById('totalIncome').textContent = incomeData.totalIncome.toFixed(2);
        document.getElementById('totalExpenses').textContent = incomeData.totalExpenses.toFixed(2);
        document.getElementById('balance').textContent = incomeData.balance.toFixed(2);

        // Update expense history table
        let tableBody = document.getElementById('expenseHistory');
        tableBody.innerHTML = '';
        incomeData.expenses.forEach(function (expense, index) {
            let row = document.createElement('tr');
            row.innerHTML = `
                <td>${expense.title}</td>
                <td>${expense.amount.toFixed(2)}</td>
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
            listItem.textContent = audit.message;
            auditTrailList.appendChild(listItem);
        });
    }

    // Function to update local storage with current incomeData
    function updateLocalStorage() {
        localStorage.setItem("incomeData", JSON.stringify(incomeData));
    }

    // Function to reset all data
    window.resetAll = function () {
        incomeData.totalIncome = 0;
        incomeData.totalExpenses = 0;
        incomeData.balance = 0;
        incomeData.expenses = [];
        incomeData.auditTrail = [];

        updateLocalStorage();
        updateUI();
    }

    // Load data from local storage
    function loadData() {
        const data = localStorage.getItem("incomeData");
        if (data) {
            incomeData = JSON.parse(data);
        }
        updateUI();
    }

    loadData();

    // Add income
    document.getElementById('incomeForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const incomeTitle = document.getElementById('income').value;
        const incomeAmount = parseFloat(document.getElementById('incomeAmount').value);

        if (incomeTitle && !isNaN(incomeAmount)) {
            incomeData.totalIncome += incomeAmount;
            incomeData.balance += incomeAmount;

            incomeData.auditTrail.push({
                message: `Added income: ${incomeTitle} - $${incomeAmount.toFixed(2)}`
            });

            updateLocalStorage();
            updateUI();

            document.getElementById('incomeForm').reset();
        }
    });

    // Add expense
    document.getElementById('expenseForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const expenseTitle = document.getElementById('expense').value;
        const expenseAmount = parseFloat(document.getElementById('expenseAmount').value);

        if (expenseTitle && !isNaN(expenseAmount)) {
            incomeData.totalExpenses += expenseAmount;
            incomeData.balance -= expenseAmount;
            incomeData.expenses.push({
                title: expenseTitle,
                amount: expenseAmount
            });

            incomeData.auditTrail.push({
                message: `Added expense: ${expenseTitle} - $${expenseAmount.toFixed(2)}`
            });

            updateLocalStorage();
            updateUI();

            document.getElementById('expenseForm').reset();
        }
    });

    // Edit expense
    window.editExpense = function (index) {
        const expense = incomeData.expenses[index];
        const newTitle = prompt("Edit expense title:", expense.title);
        const newAmount = parseFloat(prompt("Edit expense amount:", expense.amount));

        if (newTitle && !isNaN(newAmount)) {
            incomeData.totalExpenses -= expense.amount;
            incomeData.balance += expense.amount;

            expense.title = newTitle;
            expense.amount = newAmount;

            incomeData.totalExpenses += newAmount;
            incomeData.balance -= newAmount;

            incomeData.auditTrail.push({
                message: `Edited expense: ${expense.title} - $${expense.amount.toFixed(2)}`
            });

            updateLocalStorage();
            updateUI();
        }
    }

    // Remove expense
    window.removeExpense = function (index) {
        const expense = incomeData.expenses[index];
        incomeData.totalExpenses -= expense.amount;
        incomeData.balance += expense.amount;
        incomeData.expenses.splice(index, 1);

        incomeData.auditTrail.push({
            message: `Removed expense: ${expense.title} - $${expense.amount.toFixed(2)}`
        });

        updateLocalStorage();
        updateUI();
    }
});
