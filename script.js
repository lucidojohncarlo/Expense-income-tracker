function addTransaction() {
    const type = document.getElementById('type').value;
    const description = document.getElementById('description').value;
    const amount = document.getElementById('amount').value;

    if (description === '' || amount === '') {
        alert('Please fill in all fields');
        return;
    }

    const transactionList = document.getElementById('transaction-list');
    const transactionItem = document.createElement('li');

    transactionItem.classList.add(type);
    transactionItem.innerHTML = `${description} - $${amount}`;

    transactionList.appendChild(transactionItem);

    document.getElementById('description').value = '';
    document.getElementById('amount').value = '';
}
