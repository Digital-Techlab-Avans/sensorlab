const showAlert = (text, showButton = false)  => {
    const alertCard = document.getElementById('alert-card');
    const alertText = document.getElementById('alert-text');
    const progressBar = document.getElementById('progress-bar');
    const checkoutButton = document.getElementById('checkout-button');

    alertText.innerHTML = text;
    alertCard.style.display = 'block';

    if (showButton) {
        checkoutButton.style.display = 'inline-block';
    } else {
        checkoutButton.style.display = 'none';
    }

    progressBar.style.width = '100%';

    let progress = 100;
    const interval = setInterval(() => {
        progressBar.style.width = progress + '%';
        progress -= 1;

        if (progress < 0) {
            clearInterval(interval);
            setTimeout(() => {
                alertCard.style.display = 'none';
            }, 500);
        }
    }, 50);
};


document.addEventListener('DOMContentLoaded', function () {
    const closeBtn = document.querySelector('[data-bs-dismiss="hide"]');
    const alertCard = document.getElementById('alert-card');

    closeBtn.addEventListener('click', function () {
        alertCard.style.display = 'none';
    });
});
