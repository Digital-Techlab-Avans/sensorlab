$(document).ready(function () {
    $('#product-search-input-assigned').on('input', function () {
        let searchKeyword = $(this).val().toLowerCase();
        filterProductCards(searchKeyword, '#assigned');
    });

    $('#product-search-input-unassigned').on('input', function () {
        let searchKeyword = $(this).val().toLowerCase();
        filterProductCards(searchKeyword, '#unassigned');
    });

    function filterProductCards(searchKeyword, tabContentSelector) {
        $(tabContentSelector).find('.product-card').each(function () {
            let productName = $(this).data('product-name').toLowerCase();
            if (productName.includes(searchKeyword)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function handlePromise(promise, productCard, button) {
        promise.then(function (requestResponse) {
            const parentElement = productCard.parent();

            let siblingId = null;
            if (parentElement.attr('id') === 'assigned') {
                siblingId = 'unassigned';
            } else {
                siblingId = 'assigned';
            }
            moveCard(productCard, siblingId, button);

        }).catch(function (error) {
            console.log(error);
        });
    }

    function toggleButton(button) {
        if (button.classList.contains('add-btn')) {
            button.classList.remove('add-btn');
            button.classList.add('delete-btn');

            let svgElement = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            svgElement.setAttribute("xmlns", "http://www.w3.org/2000/svg");
            svgElement.setAttribute("width", "16");
            svgElement.setAttribute("height", "16");
            svgElement.setAttribute("fill", "currentColor");
            svgElement.setAttribute("class", "bi bi-trash");
            svgElement.setAttribute("viewBox", "0 0 16 16");

            // Create and set the path elements
            let pathElement1 = document.createElementNS("http://www.w3.org/2000/svg", "path");
            pathElement1.setAttribute("d", "M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z");
            svgElement.appendChild(pathElement1);

            let pathElement2 = document.createElementNS("http://www.w3.org/2000/svg", "path");
            pathElement2.setAttribute("fill-rule", "evenodd");
            pathElement2.setAttribute("d", "M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z");
            svgElement.appendChild(pathElement2);
            button.innerHTML = '';
            button.appendChild(svgElement);
        } else if (button.classList.contains('delete-btn')) {
            button.classList.remove('delete-btn');
            button.classList.add('add-btn');
            button.innerHTML = '+';
        }
    }

    function moveCard(productCard, targetContainerId, button) {

        let targetContainer = $("#" + targetContainerId);

        productCard.detach();
        toggleButton(button)

        productCard.appendTo(targetContainer);
    }

    function handleCategoryProduct(type, url, categoryId, productId, button) {
        const productCard = $(document).find("#product-card-" + productId);
        const promise = new Promise(function (resolve, reject) {
            $.ajax({
                type: type,
                url: url,
                data: {
                    categoryId: categoryId,
                    productId: productId
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
        handlePromise(promise, productCard, button);
    }

    $(document).on('click', '.delete-btn', function() {
        const productId = $(this).data('product-id');
        const categoryId = $(this).data('category-id');
        const url = '/categories/details/' + categoryId;
        handleCategoryProduct('DELETE', url, categoryId, productId, this);
    });

    $(document).on('click', '.add-btn', function() {
        const productId = $(this).data('product-id');
        const categoryId = $(this).data('category-id');
        const url = '/categories/details/' + categoryId;

        handleCategoryProduct('POST', url, categoryId, productId, this);
    });
});