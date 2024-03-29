<?php

namespace App\Rules;

use App\Libs\ConfigUtil;
use App\Repositories\GroupRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckNotExistID implements ValidationRule
{
    public $groupRepository;

    /**
     * Check if ID not exists
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->groupRepository = new GroupRepository();

        $entity = $this->groupRepository->getById($value);

        if (! $entity || $entity->deleted_date !== null) {
            $fail(ConfigUtil::getMessage('EBT094', [':attribute']));
        }
    }
}
