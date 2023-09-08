<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateOTPRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => 'required|exists:users,mobile'
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => 'Введите Mobile phone для авторизации',
            'mobile.exists' => 'Такого номера нету в нашей базе',
        ];
    }
}
