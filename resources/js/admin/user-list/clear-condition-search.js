$().ready(function() { 
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
        }
    });
    
    $('#btn-clear-condition-search').on('click', function(e) {
        $.ajax({
            url: `/admin/user/clear`,
            type:'POST',
            dataType: 'json',
            success: function(response) {
                if(response) {
                    let inputElements = $('#user-list-search-form input[name]') 
                    $.each(inputElements, function(i, element) {
                        $(element).val('');
                    })
                }
            },
        });
    })
});