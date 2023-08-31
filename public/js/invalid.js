const input = document.getElementById('amount-' + document.getElementById('productId').value);
const maxAmount = parseInt(document.getElementById('productAmount').value);

input.addEventListener('input', function (event) {
    const value = event.target.value;
    if (value > maxAmount) {
        alert('De geselecteerde hoeveelheid is groter dan de geleende hoeveelheid.');
        event.target.value = maxAmount;
    }
});
