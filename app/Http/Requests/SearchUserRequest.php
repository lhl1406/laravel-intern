<?php

namespace App\Http\Requests;

use App\Libs\ConfigUtil;
use DateTime;
use Illuminate\Foundation\Http\FormRequest;

class SearchUserRequest extends FormRequest
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
        $checkGreaterStart = DateTime::createFromFormat('d/m/Y',
            $this->get('started_date_from')) ? '|after_or_equal:started_date_from' : '';

        return [
            'name' => 'max:100',
            'started_date_from' => 'nullable|date_format:"d/m/Y"',
            'started_date_to' => 'nullable|date_format:"d/m/Y"'.$checkGreaterStart,
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
            'name.max' => ConfigUtil::getMessage('EBT002', [
                ':attribute',
                ':max',
                $this->getLenghtOfValueByAttributeName('name'),
            ]),
            'started_date_to.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'started_date_to.date_format' => ConfigUtil::getMessage('EBT008', [':attribute']),
            'started_date_to.after_or_equal' => ConfigUtil::getMessage('EBT044'),
            'started_date_from.date_format' => ConfigUtil::getMessage('EBT008', [':attribute']),
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'started_date_from' => 'Started Date From',
            'started_date_to' => 'Started Date To',
        ];
    }
}
