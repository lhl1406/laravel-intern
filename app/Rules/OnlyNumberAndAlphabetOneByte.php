<?php

namespace App\Rules;

use App\Libs\ConfigUtil;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OnlyNumberAndAlphabetOneByte implements ValidationRule
{
    /**
     * Check the number of characters is different from the total number of bytes
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (mb_strlen($value) != strlen($value) || preg_match("/^[ -~]+$/", $value) == 0) {
            $fail(ConfigUtil::getMessage('EBT005', [':attribute']));
        }
    }
}
