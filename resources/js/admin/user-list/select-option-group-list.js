$(document).ready(function(){
    let optionListWrap = $('.option-list-wrap');
    let optionElements = $('li.option-item');
    let optionSelected = $('span#option-selected');
    let inputGroupId = $('input[name="group_id"]');

    $('#option-first').on('click', function() {
        $(inputGroupId).removeAttr('hidden');
        $(inputGroupId).focus();
    })

    $(inputGroupId).on('focusin',function() {
        $(optionListWrap).toggleClass('active');
        $(optionListWrap).css('opacity', 1);
    })

    optionElements.each(function( index, element ) {
        $(element).on('click', function() {
            resetActive(optionElements);
            $(element).addClass('active');
            $(optionSelected).text($(element).text());
            $(inputGroupId).val($(element).data('group_id'));
            $(inputGroupId).valid();
            $(optionListWrap).toggleClass('active');
        });
    });

    $(inputGroupId).on('focusout',function() {
        $(this).valid();
        $(optionListWrap).css('opacity', 0);
    })

    function resetActive(optionElements) {
        optionElements.each(function( index, element ) {
            $(element).removeClass('active');
        });
    }
    function setDefault() {
        optionElements.each(function( index, element ) {
            if($(element).hasClass('active')) {
                $(optionSelected).text($(element).text());
                $(inputGroupId).val($(element).data('group_id'));
            }
        });

        return true;
    }
    setDefault();
});