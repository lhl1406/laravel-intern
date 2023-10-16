$().ready(function() {
    $.validator.addMethod('filesize', function(value, element, param) {
        let size = param.split('MB')[0] * 1024 * 1024;
       return this.optional(element) || (size !== NaN && element.files[0].size <= size) 
    });
   
    $.validator.addMethod('extension', function (value, element, param) {
       param = typeof param === 'string' ? param.replace(/,/g, '|') : 'png|jpe?g';
       return this.optional(element) || value.match(new RegExp('.(' + param + ')$', 'i'));
    });

    $.validator.addMethod('katakanaMaxLength', function (value, element, param) {
        return this.optional(element) || Array.from(value).length <= param;
    });

    $.validator.addMethod('date', function (value, element, param) {
        const regexForDate = /(?:(?:31(\/)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})/gi;
        const regexForNotAphabet = /^[\d\/]+$/;
        return this.optional(element) || regexForDate.test(value) && regexForNotAphabet.test(value);
    });

    jQuery.validator.addMethod("greaterStart", function (value, element, param) {
        let [dayFrom, monthFrom, yearFrom] = $(param).val().split('/');
        const dateFrom = new Date(+yearFrom, +monthFrom - 1, +dayFrom);

        let [dayTo, monthTo, yearTo] = value.split('/');
        const dateTo = new Date(+yearTo, +monthTo - 1, +dayTo);

        if (! /Invalid|NaN/.test(dateFrom) && !/Invalid|NaN/.test(dateTo)) {
            return this.optional(element) || dateTo >= dateFrom;
        }

        return true;
    });
  
    $.validator.addMethod('email', function (value, element) {
        const regexIfHasQuotes = /^["].+["]@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/
        const regexForEmail = /^[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/;
        
        if(regexIfHasQuotes.test(value)) {
            return true;
        }

        return this.optional(element) || regexForEmail.test(value);
    });

    $.validator.addMethod('onlyNumberAndAlphabetForPassword', function (value, element) {
        const regexEx = /^(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-z]+$/g;
        return this.optional(element) || regexEx.test(value);
    });

    $.validator.addMethod('stringValueRange', function (value, element, param) {
        return this.optional(element) || param[0] <= value.length &&  value.length <= param[1];
    });

    $.validator.addMethod('onlyNumberAndAlphabetOneByte', function (value, element) {
        const regexEx = /^[ -~]+$/;
        return this.optional(element) || new Blob([value]).size == value.length && regexEx.test(value);
    });

    $.validator.addMethod('notNull', function (value, element) {
        return this.optional(element) || value != 'null';
    });
});