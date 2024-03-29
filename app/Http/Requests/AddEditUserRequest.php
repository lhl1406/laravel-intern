<?php

namespace App\Http\Requests;

use App\Libs\ConfigUtil;
use App\Rules\KatakanaMaxLength;
use App\Rules\NotNull;
use App\Rules\OnlyNumberAndAlphabetOneByte;
use Illuminate\Foundation\Http\FormRequest;

class AddEditUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $requriedOrNullable = isset($this->id) ? 'nullable' : 'required';
        if (! isset($this->id)) {
            $requriedOrNullableForPasswordConfirm = 'required';
        } else {
            if (isset($this->password)) {
                $requriedOrNullableForPasswordConfirm = 'required';
            } else {
                $requriedOrNullableForPasswordConfirm = 'nullable';
            }
        }

        $id = $this->id ?? -1;

        return [
            'name' => [
                'required',
                new KatakanaMaxLength(100),
            ],
            'email' => [
                'required',
                'email',
                'unique:user,email,'.$id,
                'max:255',
            ],
            'group_id' => [
                'required',
                new NotNull(),
                new OnlyNumberAndAlphabetOneByte(),
            ],
            'started_date' => [
                'required',
                'date_format:"d/m/Y"',
            ],
            'position_id' => [
                'required',
                new NotNull(),
                new OnlyNumberAndAlphabetOneByte(),
            ],
            'password' => [
                $requriedOrNullable,
                'regex:/^(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-z]+$/',
                'max:20',
                'between:8,20',
            ],
            'password_confirmation' => [
                $requriedOrNullableForPasswordConfirm,
                'max:20',
                'same:password',
            ],
        ];
    }

    /**
     * Get length of value by atrribute name
     *
     * @return int
     */
    public function getLenghtOfValueByAttributeName(string $attributeName)
    {
        $attribute = $this->get($attributeName);

        return strlen($attribute);
    }

    public function messages()
    {
        return [
            'name.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'name.max' => ConfigUtil::getMessage('EBT002', [
                ':attribute',
                ':max',
                $this->getLenghtOfValueByAttributeName('name'),
            ]),
            'email.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'email.email' => ConfigUtil::getMessage('EBT004'),
            'email.unique' => ConfigUtil::getMessage('EBT019'),
            'email.max' => ConfigUtil::getMessage('EBT002', [
                ':attribute',
                ':max',
                $this->getLenghtOfValueByAttributeName('email'),
            ]),
            'group_id.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'started_date.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'started_date.date_format' => ConfigUtil::getMessage('EBT008', [':attribute']),
            'position_id.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'password.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'password.regex' => ConfigUtil::getMessage('EBT025', [':attribute']),
            'password.max' => ConfigUtil::getMessage('EBT002', [
                ':attribute',
                ':max',
                $this->getLenghtOfValueByAttributeName('password'),
            ]),
            'password.between' => ConfigUtil::getMessage('EBT023'),
            'password_confirmation.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'password_confirmation.same' => ConfigUtil::getMessage('EBT030'),
            'password_confirmation.max' => ConfigUtil::getMessage('EBT002', [
                ':attribute',
                ':max',
                $this->getLenghtOfValueByAttributeName('password_confirmation'),
            ]),
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'User Name',
            'email' => 'Email',
            'group_id' => 'Group',
            'started_date' => 'Started Date',
            'position_id' => 'Position',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',
        ];
    }
}
