$().ready(function() { 
    $('#importForm input[name="file"]').on('change', function() {
        $(this).valid();
    })

    let elementError = $('div.error-message-list');

    $('#importForm').validate({
        onkeyup: false,
        rules: {
            'file': {
                extension: 'csv|txt',
                filesize : '1MB',
            },
        },
        messages: {
            'file': {
                filesize: function(size) {
                    return jQuery.validator.messages.filesize(size);
                },
                extension: function(extension) {
                    return jQuery.validator.messages.extension('CSV');
                }
            },
        },
        onfocusout: function(element) {
            elementError.html('');
            $(element).valid();
        },
        onfocusin: function(element) {
            $(element).valid();
        },
        onkeyup: function(element) {
            $(element).valid();
        },
        errorPlacement: function(error, element) {
            elementError.html(error); 
        },
    });
});