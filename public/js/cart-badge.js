function addCartAmounts() {
    const cookieName = 'productCookie';
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
            let totalAmount = 0;

            for (let j = 0; j < entries.length; j++) {
                let entry = entries[j];

                // Extract the amount from each entry
                let amount = entry.match(/amount";i:(\d+)/);

                if (amount) {
                    totalAmount += parseInt(amount[1]);
                }
            }

            return totalAmount;
        }
    }

    return 0;
}

function updateCartBadge() {
    const entryCount = addCartAmounts();
    const badge = document.getElementById('cart-badge');
    if(entryCount > 0){
        if(entryCount > 99){
            badge.innerHTML = "99+";
            badge.setAttribute('aria-label', "Aantal producten in winkelwagen: Meer dan 99");
        }else{
            badge.innerHTML = entryCount;
            badge.setAttribute('aria-label', "Aantal producten in winkelwagen: " + entryCount);
        }
        badge.style.display = 'block';
    }else{
        badge.setAttribute('aria-label', "Aantal producten in winkelwagen: 0");
        badge.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge();
});