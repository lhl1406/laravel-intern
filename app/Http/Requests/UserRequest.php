<?php

namespace App\Http\Requests;

use App\Libs\ConfigUtil;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        return [
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ConfigUtil::getMessage('EBT001', ['Email']),
            'email.email' => ConfigUtil::getMessage('EBT004'),
            'password.required' => ConfigUtil::getMessage('EBT001', ['Password']),
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}
