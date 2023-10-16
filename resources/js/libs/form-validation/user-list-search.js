$( function() {
    const startedDateTo = $('#started_date_to');
    const startedDateFrom =  $('#started_date_from');

    startedDateFrom.datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: new Date(2023, 1 - 1, 1),
    }).on('change', function() {
        $(this).valid();
        $(startedDateTo).valid();
    });

    startedDateTo.datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: new Date(2023, 1 - 1, 2),
    }).on('change', function() {
        $(this).valid();
    });

    $('#user-list-search-form').validate({
        onkeyup: false,
        onclick: false,
        rules: {
            'name': {
                maxlength: 100,
            },
            'started_date_from': {
                date: true,
            },
            'started_date_to': {
                date: true,
                greaterStart: '#started_date_from',
            },
        },
        messages: {
            'name': {
                maxlength: function(param, element) {
                    let attributeName = $(element).data('content');
                    let length = Array.from($(element).val()).length;
                    return jQuery.validator.messages.max(attributeName, param, length);
                },
            },
            'started_date_from': {
                date: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.date(attributeName);
                },
            },
            'started_date_to': {
                date: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.date(attributeName);
                },
            },
        },
        errorPlacement: function(error, element) {
            const parrentElementGroupInput = element.closest('.group-input-user-list');
            const childrenElementError = $(parrentElementGroupInput).children('div.error-div');
            error.appendTo(childrenElementError);
        },
        onfocusout: function(element) {
            $(element).valid();
        },
        onkeyup: function(element) {
            $(element).valid();
        },
        submitHandler: function(form) {
            if($(form).data('is-submitted') === undefined) {
                $(form).data('is-submitted', true)
                form.submit();
            }
        },
    });
} );

