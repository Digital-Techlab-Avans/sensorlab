$(document).ready(function () {
    checkInputForSubmitButton();

    $('#new_due_date_form').on('input', function () {
        checkInputForSubmitButton();
    });

    function checkInputForSubmitButton() {
        if ($('#new_due_date_form input[name="datetime"]').val() !== "") {
            $('#due_date_submit_button').prop('disabled', false);
        } else {
            $('#due_date_submit_button').prop('disabled', true);
        }
    }
})
