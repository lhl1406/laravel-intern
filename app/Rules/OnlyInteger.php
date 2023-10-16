<?php

namespace App\Rules;

use App\Libs\ConfigUtil;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OnlyInteger implements ValidationRule
{
    /**
     * Check integer number
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (preg_match("/^([+-])?[0-9]+(\.[0-9]+[Ee][+][0-9]+)?$/", $value) == 0) {
            $fail(ConfigUtil::getMessage('EBT010', [':attribute']));
        }
    }
}
