function submitForm() {
    updateValues();
    let form = document.getElementById("all-products");
    form.submit();
}

function updateValues() {
    const productCards = document.querySelectorAll('div.input-group');
    productCards.forEach(function (card) {
        const productId = card.getAttribute('data-productId');
        const input = document.getElementById("amount-" + productId);
        if (input) {
            const hiddenInput = document.getElementById("hidden-amount-" + productId);
            if (hiddenInput) {
                hiddenInput.value = input.value;
            }
        }
    })
}

const loanCardInputs = document.querySelectorAll('.loan-card-input');

// Add event listener to each loan-card-input element
loanCardInputs.forEach(function (input) {
    input.addEventListener('change', function () {
        // Get the productId from the data attribute
        const productId = input.dataset.productid;

        // Get the new value of the loan-card-input
        const newValue = input.value;

        // Call your function with the productId and the new value
        updateCookieAmount(productId, newValue);
        updateCartBadge();
    });
});

function updateCookieAmount(productId, newAmount) {
    const cookieName = "productCookie";
    const cookies = document.cookie.split(';');
    let foundCookie = '';
    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].trim();
        if (cookie.indexOf(cookieName + '=') === 0) {
            foundCookie = cookie.substring(cookieName.length + 1);
            break;
        }
    }

    if (foundCookie !== '') {
        // Extract the serialized PHP array
        let serializedArray = decodeURIComponent(foundCookie);

        // Clean up the serialized array string
        serializedArray = serializedArray.replace(/\\(.)/g, '$1');

        // Parse the serialized array string
        let entries = serializedArray.match(/a:\d+:{.*?}/g);
        if (entries) {
            for (let j = 0; j < entries.length; j++) {
                let entry = entries[j];
                // Extract the product ID from each entry
                let id = entry.match(/id\";i:(\d+)/);

                if (parseInt(id[1]) == productId) {
                    // Update the amount of the matching product
                    let updatedEntry = entry.replace(/amount";i:\d+/, `amount";i:${newAmount}`);
                    serializedArray = serializedArray.replace(entry, updatedEntry);
                    break;
                }
            }

            // Update the cookie with the modified serialized array
            document.cookie = `${cookieName}=${encodeURIComponent(serializedArray)}; path=/`;
        }
    }
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();

        let between = $(this).data('between');
        let productId = $(this).data('product-id');
        let amount = $('#amount-' + between + productId).val();

        addToCart('/products/overview/loaners', productId, amount);
    });

    $('.admin-add-to-cart').on('click', function (e) {
        e.preventDefault();

        let loanerId = $(this).data('loaner-id');
        let productId = $(this).data('product-id');
        let between = $(this).data('between');
        let amount = $('#amount-' + between + productId).val();

        addToCart('/loaners/' + loanerId + '/loaning', productId, amount, loanerId);
    });
});


function addToCart(url, productId, amount, loanerId = null) {
    const data = {
        productId: productId,
        amount: amount,
    };

    if (loanerId) {
        data.loanerId = loanerId;
    }

    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function (response) {
            if (loanerId) {
                location.reload();

            } else {
                showAlert('Product is toegevoegd aan de winkelwagen.', true);
            }
            updateCartBadge();
        },

        error: function (xhr) {
            const errorMsg = loanerId
                ? 'Er is een fout opgetreden bij het toevoegen van het product aan de winkelwagen van de lener.'
                : 'Er is een fout opgetreden bij het toevoegen van het product aan de winkelwagen.';
            showAlert(errorMsg);
        },
    });
}
