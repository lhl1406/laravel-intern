$().ready(function() {
    jQuery.extend(jQuery.validator.messages, {
        required: jQuery.validator.format('{0}は必須です。'),
        katakanaMaxLength: jQuery.validator.format('{0}は「{1}」文字以下で入力してください。（現在{2}文字）'),
        email: jQuery.validator.format('メールアドレスを正しく入力してください。'),
        max: jQuery.validator.format('{0}は「{1}」文字以下で入力してください。（現在{2}文字）'),
        date: jQuery.validator.format('{0}は日付を正しく入力してください。'),
        greaterStart: jQuery.validator.format('解約予定日は契約終了日前を指定してください。'),
        onlyNumberAndAlphabetForPassword: jQuery.validator.format('パスワードには半角数字のみ、または半角英字のみの値は使用できません。'),
        onlyNumberAndAlphabetOneByte: jQuery.validator.format('{0}は半角英数で入力してください。'),
        stringValueRange: jQuery.validator.format('パスワードは半角英数字記号で8～20文字で入力してください。'),
        equalTo: jQuery.validator.format('確認用のパスワードが間違っています。'),
        existsEmail: jQuery.validator.format('すでにメールアドレスは登録されています。'),
        notNull: jQuery.validator.format('{0}は必須です。'),
        extension: jQuery.validator.format('ファイル形式が誤っています。{0}を選択してください。'),
        filesize: jQuery.validator.format('ファイルのサイズ制限{0}を超えています。'),
    });
})