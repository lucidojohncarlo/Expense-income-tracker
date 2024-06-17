document.addEventListener("DOMContentLoaded", function() {
    loadData();

    document.getElementById('incomeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        addIncome();
    });

    document.getElementById('expenseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        addExpense();
    });

    document.getElementById('resetButton').addEventListener('click', function() {
        resetAll();
    });
});

function loadData() {
    fetch('load_data.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalIncome').textContent = '₱' + data.totalIncome;
            document.getElementById('totalExpenses').textContent = '₱' + data.totalExpenses;
            document.getElementById('balance').textContent = '₱' + data.balance;
            updateExpenseHistory(data.expenses);
            updateAuditTrail(data.auditTrail);
        })
        .catch(error => console.error('Error fetching data:', error));
}

function addIncome() {
    let formData = new FormData(document.getElementById('incomeForm'));
    fetch('add_income.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            loadData();
            document.getElementById('incomeForm').reset();
        })
        .catch(error => console.error('Error adding income:', error));
}

function addExpense() {
    let formData = new FormData(document.getElementById('expenseForm'));
    fetch('add_expense.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            loadData();
            document.getElementById('expenseForm').reset();
        })
        .catch(error => console.error('Error adding expense:', error));
}

function resetAll() {
    fetch('reset_data.php', {
        method: 'POST'
    })
        .then(response => response.json())
        .then(data => {
            loadData();
        })
        .catch(error => console.error('Error resetting data:', error));
}

function updateExpenseHistory(expenses) {
    let expenseHistory = document.getElementById('expenseHistory');
    expenseHistory.innerHTML = '';
    expenses.forEach(expense => {
        let row = document.createElement('tr');
        row.innerHTML = `
            <td>${expense.title}</td>
            <td>₱${expense.amount}</td>
            <td>
                <button class="btn btn-sm btn-warning" onclick="editExpense(${expense.id}, '${expense.title}', ${expense.amount})">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="removeExpense(${expense.id})">Remove</button>
            </td>
        `;
        expenseHistory.appendChild(row);
    });
}

function updateAuditTrail(auditTrail) {
    let auditTrailContainer = document.getElementById('auditTrail');
    auditTrailContainer.innerHTML = '';
    auditTrail.forEach(entry => {
        let item = document.createElement('li');
        item.className = 'list-group-item';
        item.textContent = entry.message;
        auditTrailContainer.appendChild(item);
    });
}

function editExpense(id, title, amount) {
    let newTitle = prompt("Edit Expense Title:", title);
    let newAmount = prompt("Edit Expense Amount:", amount);
    if (newTitle !== null && newAmount !== null) {
        let formData = new FormData();
        formData.append('id', id);
        formData.append('title', newTitle);
        formData.append('amount', newAmount);
        fetch('edit_expense.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                loadData();
            })
            .catch(error => console.error('Error editing expense:', error));
    }
}

function removeExpense(id) {
    if (confirm("Are you sure you want to remove this expense?")) {
        let formData = new FormData();
        formData.append('id', id);
        fetch('remove_expense.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                loadData();
            })
            .catch(error => console.error('Error removing expense:', error));
    }
}
