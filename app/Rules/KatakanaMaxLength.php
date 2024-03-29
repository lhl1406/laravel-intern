<?php

namespace App\Rules;

use App\Libs\ConfigUtil;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class KatakanaMaxLength implements ValidationRule
{
    public $maxLength;

    /**
     * Create a new rule instance.
     */
    public function __construct($maxLength)
    {
        $this->maxLength = $maxLength;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (mb_strlen($value) > $this->maxLength) {
            $fail(ConfigUtil::getMessage('EBT002', [':attribute', $this->maxLength, mb_strlen($value)]));
        }
    }
}
