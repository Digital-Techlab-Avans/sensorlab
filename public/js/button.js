$(document).ready(function () {

    let inputvalues = document.getElementById('inputvalues');

    const min = inputvalues?.dataset?.min ?? 0;
    const max = inputvalues?.dataset?.max ?? 100;

    $('.add-comment-btn').click(function () {
        let productId = $(this).data('target');
        $('#comment-row-' + productId).toggle();
    });

    $('.show-body-btn').click(function () {
        $(this).closest('.card').find('.card-body').toggle();
        $(this).toggleClass('show-icon');
    });

    $('.decrease-amount-btn').click(function () {
        let inputElement = $(this).siblings('.amount-input');
        let currentAmount = parseInt(inputElement.val());

        if (!isNaN(currentAmount) && currentAmount > min) {
            let newAmount = currentAmount - 1;
            inputElement.val(newAmount).attr('value', newAmount).trigger('input');
            updateAriaValue(inputElement[0]);
        }

        let changeEvent = new Event('change');
        inputElement[0].dispatchEvent(changeEvent);
    });

    $('.increase-amount-btn').click(function () {
        let inputElement = $(this).siblings('.amount-input');
        let currentAmount = parseInt(inputElement.val());
        let maxVal = inputElement.attr('max');

        if (maxVal && currentAmount >= maxVal) {
            return;
        }

        let newAmount = currentAmount + 1;
        inputElement.val(newAmount).attr('value', newAmount).trigger('input');
        updateAriaValue(inputElement[0]);

        // Manually create and dispatch a change event
        let changeEvent = new Event('change');
        inputElement[0].dispatchEvent(changeEvent);
    });

    $('#cardViewBtn').click(function () {
        $('#cardView').show();
        $('#listView').hide();
        $('#dropdownMenuButton').html('Weergave: Card');
    });

    $('#listViewBtn').click(function () {
        $('#cardView').hide();
        $('#listView').show();
        $('#dropdownMenuButton').html('Weergave: Lijst');
    });
});

function updateAriaValue(input) {
    input.setAttribute('aria-label', 'Huidige hoeveelheid: ' + input.value);
}


