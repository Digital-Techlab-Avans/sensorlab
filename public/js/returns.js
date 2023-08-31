$(document).ready(function () {

    checkUserCards();

    $('.show-body-btn').click(function () {
        $(this).closest('.card').find('.card-body').toggle();
        $(this).toggleClass('show-icon');
        $(this).find(".fa-caret-down, .fa-caret-up").toggleClass("fa-caret-down fa-caret-up");
    });

    $('.add-return-comment-btn').click(function () {
        let productId = $(this).data('product');
        let userId = $(this).data('user');
        let parentCard = $(this).closest('.card');
        let commentRow = parentCard.find('.comment-row.comment-row-' + productId + '-' + userId);
        let badge = parentCard.find('#badge-' + productId + '-' + userId)
        commentRow.toggle();
        badge.hide();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function removeUserCard(userId, returnId) {
        const userCard = $(document).find('#user-card-' + userId);
        let amountOfReturns = $('.return-card-' + userId).length;
        if (amountOfReturns < 2) {
            $(document).find('.all-buttons-' + userId).remove();
        }
        if (amountOfReturns < 1) {
            userCard.remove();
        }
        checkUserCards();
    }

    function checkUserCards(){
        const amountOfUsers = $('.user-card').length;
        if(amountOfUsers < 1){
            $('.no-returns').css('display', 'block');
        }
    }

    function alertUser(response) {
        showAlert(response);
    }

    function handleAllReturns(url, returnIds, comments, userId) {
        const userCard = $(`#user-card-${userId}`);

        // Send an AJAX request to accept/reject all the returns with their corresponding comments
        const promise = new Promise(function (resolve, reject) {
            let requestResponse = 'empty';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    returnIds: returnIds,
                    comments: comments
                },
                success: function (response) {
                    requestResponse = response.message;
                    // Resolve the Promise with the response message
                    resolve(requestResponse);
                },
                error: function (xhr, status, error) {
                    requestResponse = 'Er is iets misgegaan';
                    // Reject the Promise with the error message
                    reject(requestResponse);
                }
            });
        });

        promise.then(function (requestResponse) {
            alertUser(requestResponse);
            userCard.remove();
            checkUserCards();
        }).catch(function (error) {
            alertUser(error);
        });
    }

    $('.approve-all-btn').click(function () {
        const userName = $(this).data('user-name');
        let confirmed = confirm("Weet je zeker dat je alle inleveringen van " + userName + " wilt goedkeuren?");
        if (confirmed) {
            const userId = $(this).data('user-id');
            let returnIds = [];
            let comments = [];
            $(`.return-card-${userId}`).each(function () {
                let returnId = $(this).data('return-id');
                returnIds.push(returnId);
                let comment = $(this).find(`#comment-${returnId}`).val()
                comments.push({
                    returnId,
                    comment
                });
            });
            handleAllReturns('/returns/accept', returnIds, comments, userId);
        }
    });


    // Reject all returns
    $('.reject-all-btn').click(function () {
        const userName = $(this).data('user-name');
        let confirmed = confirm("Weet je zeker dat je alle inleveringen van " + userName + " wilt afkeuren?");
        if (confirmed) {
            const userId = $(this).data('user-id');
            let returnIds = [];
            let comments = [];
            $(`.return-card-${userId}`).each(function () {
                let returnId = $(this).data('return-id');
                returnIds.push(returnId);
                let comment = $(this).find(`#comment-${returnId}`).val()
                comments.push({
                    returnId,
                    comment
                });
            });
            handleAllReturns('/returns/reject', returnIds, comments, userId);
        }
    });

    // Accept a single return
    function handlePromise(promise, returnCard, userId, returnId) {
        promise.then(function (requestResponse) {
            alertUser(requestResponse);
            returnCard.remove();
            removeUserCard(userId, returnId);
        }).catch(function (error) {
            alertUser(error);
        });
    }

    // Accept a single return
    $('.accept-return-btn').click(function () {
        const userName = $(this).data('user-name');
        let confirmed = confirm("Weet je zeker dat je de inlevering van " + userName + " wilt goedkeuren?");
        if (confirmed) {
            const returnId = $(this).data('return-id');
            const comment = $(document).find('#comment-' + returnId).val();
            const returnCard = $(document).find('#return-card-' + returnId);
            const userId = $(this).data('user-id');
            // Create a new Promise object
            const promise = new Promise(function (resolve, reject) {
                let requestResponse = 'empty';
                $.ajax({
                    url: '/returns/' + returnId + '/accept',
                    type: 'POST',
                    data: {
                        returnId: returnId,
                        comment: comment
                    },
                    success: function (response) {
                        requestResponse = response.message;
                        // Resolve the Promise with the response message
                        resolve(requestResponse);
                    },
                    error: function (xhr, status, error) {
                        requestResponse = 'Er is iets misgegaan';
                        // Reject the Promise with the error message
                        reject(requestResponse);
                    }
                });
            });

            // Call the handlePromise function
            handlePromise(promise, returnCard, userId, returnId);
        }
    });

    // Reject a single return
    $('.reject-return-btn').click(function () {
        const userName = $(this).data('user-name');
        let confirmed = confirm("Weet je zeker dat je de inlevering van " + userName + " wilt afkeuren?");
        if (confirmed) {
            const returnId = $(this).data('return-id');
            const comment = $(document).find('#comment-' + returnId).val();
            const returnCard = $(document).find('#return-card-' + returnId);
            const userId = $(this).data('user-id');

            // Create a new Promise object
            const promise = new Promise(function (resolve, reject) {
                let requestResponse = 'empty';
                $.ajax({
                    url: '/returns/' + returnId + '/reject',
                    method: 'POST',
                    data: {
                        returnId: returnId,
                        comment: comment
                    },
                    success: function (response) {
                        requestResponse = response.message;
                        // Resolve the Promise with the response message
                        resolve(requestResponse);
                    },
                    error: function (xhr, status, error) {
                        requestResponse = 'Er is iets misgegaan';
                        // Reject the Promise with the error message
                        reject(requestResponse);
                    }
                });
            });

            // Call the handlePromise function
            handlePromise(promise, returnCard, userId, returnId);
        }
    });
});