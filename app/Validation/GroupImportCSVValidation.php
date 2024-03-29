<?php

namespace App\Validation;

use App\Libs\ConfigUtil;
use App\Rules\CheckNotExistID;
use App\Rules\KatakanaMaxLength;
use App\Rules\OnlyInteger;

class GroupImportCSVValidation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public static function rules($values)
    {
        $requriedOrNullable = $values['Delete'] ? 'nullable' : 'required';

        if (empty($values['ID'])) {
            $requriedOrNullable = 'required';
        }

        return [
            'ID' => ['nullable', new OnlyInteger(), new CheckNotExistID(), 'max:20'],
            'Group Name' => [$requriedOrNullable, new KatakanaMaxLength(255)],
            'Group Note' => 'nullable',
            'Group Leader' => [$requriedOrNullable, new OnlyInteger(), 'max:20'],
            'Floor Number' => [$requriedOrNullable, new OnlyInteger(), 'max:9'],
            'Delete' => 'nullable',
        ];
    }

    public static function messages($data)
    {
        return [
            'Group Name.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'Group Leader.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'Floor Number.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'ID.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'Group Leader.max' => ConfigUtil::getMessage('EBT002', [
                ':attribute',
                ':max',
                strlen($data['Group Leader']),
            ]),
            'Floor Number.max' => ConfigUtil::getMessage('EBT002', [
                ':attribute',
                ':max',
                strlen($data['Floor Number']),
            ]),
            'ID.max' => ConfigUtil::getMessage('EBT002', [
                ':attribute',
                ':max',
                strlen($data['ID']),
            ]),
        ];
    }

    public static function attributes()
    {
        return [
            'ID' => 'ID',
            'Group Name' => 'Group Name',
            'Floor Number' => 'Floor Number',
            'Group Leader' => 'Group Leader',
            'Group Note' => 'Group Note',
            'Delete' => 'Delete',
        ];
    }
}
