$().ready(function() {
    $('#login-form').validate({
        onclick: false,
        rules: {
            'email': {
                required: true,
                email: true,
            },
            'password': {
                required: true,
            },
        },
        messages: {
            'email': {
                required: function() {
                    return jQuery.validator.messages.required('Email');
                },
                email: function() {
                    return jQuery.validator.messages.email();
                },
            },
            'password': {
                required: function() {
                    return jQuery.validator.messages.required('Password');
                },
            },
        },
        errorPlacement: function(error, element) {
            const errorDiv = $(`div.error-div.error-${$(element).attr('name')}`);
            errorDiv.html(error);
        },
        onfocusin: function(element) {
           $('div.alert').css('display', 'none');
        },
        onkeyup: function(element) {
            $(element).valid();
        },
        onfocusout: function(element) {
            $(element).valid();
        },
        submitHandler: function(form) {
            if($(form).data('is-submitted') === undefined) {
                $(form).data('is-submitted', true)
                form.submit();
            }
        },
    })

});