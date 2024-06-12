// script.js

$(document).ready(function() {
    // Initial load of data
    $.ajax({
        type: 'GET',
        url: 'load_data.php',
        success: function (response) {
            const data = JSON.parse(response);
            updateUI(data);
        },
        error: function () {
            alert('Error loading data.');
        }
    });
});

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
    $('#totalIncome').text(`₱${data.totalIncome.toFixed(2)}`);
    $('#totalExpenses').text(`₱${data.totalExpenses.toFixed(2)}`);
    $('#balance').text(`₱${data.balance.toFixed(2)}`);

    // Update expense history table
    let tableBody = $('#expenseHistory');
    tableBody.empty();
    data.expenses.forEach(expense => {
        tableBody.append(`
            <tr>
                <td>${expense.title}</td>
                <td>₱${expense.amount.toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editExpense(${expense.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="removeExpense(${expense.id})">Remove</button>
                </td>
            </tr>
        `);
    });

    // Update audit trail list
    let auditTrailList = $('#auditTrail');
    auditTrailList.empty();
    data.auditTrail.forEach(audit => {
        auditTrailList.append(`<li class="list-group-item">${audit.message}</li>`);
    });
}

// Add income form submission
$('#incomeForm').submit(function(e) {
    e.preventDefault();

    const incomeTitle = $('#income').val();
    const incomeAmount = parseFloat($('#incomeAmount').val());

    if (incomeTitle && !isNaN(incomeAmount)) {
        $.ajax({
            type: 'POST',
            url: 'add_income.php',
            data: {
                income: incomeTitle,
                incomeAmount: incomeAmount
            },
            success: function (response) {
                const data = JSON.parse(response);
                updateUI(data);
            },
            error: function () {
                alert('Error adding income.');
            }
        });

        $('#incomeForm').trigger('reset');
    }
});

// Add expense form submission
$('#expenseForm').submit(function(e) {
    e.preventDefault();

    const expenseTitle = $('#expense').val();
    const expenseAmount = parseFloat($('#expenseAmount').val());

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

        $('#expenseForm').trigger('reset');
    }
});
