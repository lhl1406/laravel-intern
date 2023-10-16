$().ready(function() { 
    $('#btn-show-import-modal').on('click', function () {
        const inputFile = $('#importForm input[name="file"]');
        
        inputFile.click();
        
        inputFile.val('');

        let elementError = $('div.error-message-list');
        elementError.html('');

        $('#importForm input[name="file"]').on('change', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            if($('#importForm').valid() && $(inputFile).val() !== '') {
                $('#importForm').submit()
            }
        });

    })

    const elementError = $('div.alert');

    if(elementError.length) {
        let top = $(elementError).height();

        let nextElement = $(elementError).next();
        
        $(nextElement).animate({
            marginTop: top
        }, 1000, 'linear');
    }

    $('span.closebtn').on('click', function() {
        let nextElement = $(elementError).next();
        $(nextElement).animate({
            marginTop: 0
        }, 500, 'linear');
    });
});
