$().ready(function() {
    const startedDateFrom =  $('#started_date');

    startedDateFrom.datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: new Date(2023, 1 - 1, 1),
    }).on('change', function() {
        $(this).valid();
    });   

    $('#user-add-edit-delete-form').validate({
        onkeyup: false,
        onclick: false,
        rules: {
            'name': {
                required: true,
                katakanaMaxLength: 100,
            },
            'email': {
                required: true,
                email: true,
                maxlength: 255,
                remote: {
                    url: '/admin/user/checkExistsEmail',
                    type: "post",
                    data: {
                        id: () => $("input#userID").val(),
                        email:() => $("input[name='email']").val(),
                        _token:() => _token = $("input[name='_token']").val(),
                    },
                    dataFilter: function(data){
                        if(data == 'true') {
                            return false;
                        }
                        return true;
                    }
                },
            },
            'group_id': {
                required: true,
                notNull: true,
                onlyNumberAndAlphabetOneByte: true,
            },
            'started_date': {
                date: true,
                required: true,
            },
            'position_id': {
                required: true,
                notNull: true,
                onlyNumberAndAlphabetOneByte: true,
            },
            'password': {
                required: function() {
                    let isAdd = $('input#checkForAdd').val();
                    
                    return !!isAdd;
                },
                onlyNumberAndAlphabetForPassword: true,
                maxlength: 20,
                stringValueRange: [8, 20],
            },
            'password_confirmation': {
                required: function() {
                        let isAdd = $('input#checkForAdd').val();
                        let passWord = $('#password').val();

                        return Boolean(isAdd || passWord.length);
                },
                maxlength: 20,
                equalTo: "#password",
            },
        },
        messages: {
            'name': {
                katakanaMaxLength: function(param, element) {
                    let attributeName = $(element).data('content');
                    let length = Array.from($(element).val()).length;
                    return jQuery.validator.messages.katakanaMaxLength(attributeName, param, length);
                },
                required: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.required(attributeName);
                },
            },
            'email': {
                maxlength: function(param, element) {
                    let attributeName = $(element).data('content');
                    let length = Array.from($(element).val()).length;
                    return jQuery.validator.messages.max(attributeName, param, length);
                },
                required: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.required(attributeName);
                },
                remote: function() {
                    return jQuery.validator.messages.existsEmail();
                },
            },
            'group_id': {
                required: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.required(attributeName);
                },
                notNull: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.required(attributeName);
                },
                onlyNumberAndAlphabetOneByte: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.onlyNumberAndAlphabetOneByte(attributeName);
                },
            },
            'position_id': {
                required: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.required(attributeName);
                },
                notNull: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.required(attributeName);
                },
                onlyNumberAndAlphabetOneByte: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.onlyNumberAndAlphabetOneByte(attributeName);
                },
            },
            'started_date': {
                date: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.date(attributeName);
                },
                required: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.required(attributeName);
                },
            },
            'password': {
                required: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.required(attributeName);
                },
                maxlength: function(param, element) {
                    let attributeName = $(element).data('content');
                    let length = Array.from($(element).val()).length;
                    return jQuery.validator.messages.max(attributeName, param, length);
                },
                onlyNumberAndAlphabetForPassword: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.onlyNumberAndAlphabetForPassword(attributeName);
                },
                stringValueRange: function() {
                    return jQuery.validator.messages.stringValueRange;
                },
            },
            'password_confirmation': {
                required: function(param, element) {
                    let attributeName = $(element).data('content');
                    return jQuery.validator.messages.required(attributeName);
                },
                maxlength: function(param, element) {
                    let attributeName = $(element).data('content');
                    let length = Array.from($(element).val()).length;
                    return jQuery.validator.messages.max(attributeName, param, length);
                },
            },
        },
        onkeyup: function(element) {
            $(element).valid();
        },
        onfocusout: function(element) {
            $(element).valid();
        },
        errorPlacement: function(error, element) {
            const parrentElementGroupInput = element.closest('.group-input-user-list');
            const childrenElementError = $(parrentElementGroupInput).children('div.error-div');
            error.appendTo(childrenElementError);
        },
        submitHandler: function(form) {
            if($(form).data('is-submitted') === undefined) {
                $(form).data('is-submitted', true)
                form.submit();
            }
        },
    });

    $('.btn-delete').on('click', function () {
        $('#deletemodal').modal('show');
    })

    $('.btn-cancel').on('click', function () {
        $('#deletemodal').modal('hide');
    })
});