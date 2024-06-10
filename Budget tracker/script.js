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
                <button class="btn btn-sm btn-danger" onclick="removeExpense(${index})">Remove</button>
                <button class="btn btn-sm btn-primary" onclick="editExpense(${index})">Edit</button>
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
function resetAll() {
    incomeData.totalIncome = 0;
    incomeData.totalExpenses = 0;
    incomeData.balance = 0;
    incomeData.expenses = [];
    incomeData.auditTrail = [];

    updateLocalStorage();
    updateUI();
}

// Function to add expense
function addExpense(title, amount) {
    incomeData.totalExpenses += amount;
    incomeData.balance -= amount;
    incomeData.expenses.push({ title: title, amount: amount });
    incomeData.auditTrail.push({ message: `Added expense: ${title} - Amount: ${amount.toFixed(2)}` });

    updateLocalStorage();
    updateUI();
}

// Function to remove expense
function removeExpense(index) {
    let removedExpense = incomeData.expenses.splice(index, 1)[0];
    incomeData.totalExpenses -= removedExpense.amount;
    incomeData.balance += removedExpense.amount;
    incomeData.auditTrail.push({ message: `Removed expense: ${removedExpense.title} - Amount: ${removedExpense.amount.toFixed(2)}` });

    updateLocalStorage();
    updateUI();
}

// Function to edit expense
function editExpense(index) {
    let expenseTitle = prompt("Enter new expense title:");
    let expenseAmount = parseFloat(prompt("Enter new expense amount:"));

    if (expenseTitle && expenseAmount && !isNaN(expenseAmount) && expenseAmount > 0) {
        let oldExpense = incomeData.expenses[index];
        incomeData.totalExpenses -= oldExpense.amount;
        incomeData.balance += oldExpense.amount;

        oldExpense.title = expenseTitle;
        oldExpense.amount = expenseAmount;

        incomeData.totalExpenses += expenseAmount;
        incomeData.balance -= expenseAmount;

        incomeData.auditTrail.push({ message: `Edited expense: ${oldExpense.title} - Amount: ${oldExpense.amount.toFixed(2)}` });

        updateLocalStorage();
        updateUI();
    } else {
        alert("Invalid input. Please enter valid expense title and amount.");
    }
}

// Event listener when DOM content is loaded
document.addEventListener("DOMContentLoaded", function () {
    updateUI();

    // Event listener for adding income
    document.getElementById('incomeForm').addEventListener('submit', function (event) {
        event.preventDefault();
        let incomeInput = document.getElementById('income');
        let incomeAmountInput = document.getElementById('incomeAmount');
        let incomeTitle = incomeInput.value.trim();
        let incomeAmount = parseFloat(incomeAmountInput.value.trim());

        if (incomeTitle === '' || isNaN(incomeAmount) || incomeAmount <= 0) {
            alert('Please enter a valid income.');
            return;
        }

        // Add income to incomeData
        incomeData.totalIncome += incomeAmount;
        incomeData.balance += incomeAmount;
        incomeData.auditTrail.push({ message: `Added income: ${incomeTitle} - Amount: ${incomeAmount.toFixed(2)}` });

        // Update local storage and UI
        updateLocalStorage();
        updateUI();

        // Clear input fields
        incomeInput.value = '';
        incomeAmountInput.value = '';
    });

    // Event listener for adding expense
    document.getElementById('expenseForm').addEventListener('submit', function (event) {
        event.preventDefault();
        let expenseInput = document.getElementById('expense');
        let expenseAmountInput = document.getElementById('expenseAmount');
        let expenseTitle = expenseInput.value.trim();
        let expenseAmount = parseFloat(expenseAmountInput.value.trim());

        if (expenseTitle === '' || isNaN(expenseAmount) || expenseAmount <= 0) {
            alert('Please enter a valid expense.');
            return;
        }

        // Add expense to incomeData
        addExpense(expenseTitle, expenseAmount);

        // Clear input fields
        expenseInput.value = '';
        expenseAmountInput.value = '';
    });
});
