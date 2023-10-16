$(document).ready(function () {
    //Prevent multiple submit
    let formElements = $('form.form-submit');
    $.each(formElements, function(index, form) {
        $(form).on('submit', function(e) {
            if($(this).data('is-submit') === true) {
                e.preventDefault();
            } else {
                $(this).data('is-submit', true);
            }      
        })
    });

    (function () {
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };
    })();
})

