const batchSize = 24;

$(document).ready(function () {
    const cards = $('#cardView .row > .col');
    const totalCards = cards.length;
    let shownCards;
    if (batchSize < totalCards) {
        shownCards = batchSize;
    } else {
        shownCards = totalCards
        $('#loadMoreButton').hide();
    }


    // Hide all cards after the initial 25
    cards.slice(batchSize).hide();

    // Show more cards when the button is clicked
    $('#loadMoreButton').click(function () {
        cards.filter(':hidden').slice(0, batchSize).show();
        if ((shownCards + batchSize) < totalCards) {
            shownCards += batchSize;
        } else {
            shownCards = totalCards;
        }


        // Hide the button if all cards are shown
        if (cards.filter(':hidden').length === 0) {
            $('#loadMoreButton').hide();
            $('#shownItems').html('Toon <b>' + shownCards + '</b> van ' + totalCards);
        }

        $('#shownItems').html('Toon <b>' + shownCards + '</b> van ' + totalCards);
    });

    // Display initial count of shown items
    $('#shownItems').html('Toon <b>' + shownCards + '</b> van ' + totalCards);
});