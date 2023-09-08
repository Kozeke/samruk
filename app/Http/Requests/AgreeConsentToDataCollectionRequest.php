<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgreeConsentToDataCollectionRequest extends FormRequest
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
            'cmsConsent' => 'required',
            'subjectIIN' => 'required|exists:users,iin',
            'subjectName' => 'required',
            'cert_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cmsConsent.required' => 'Вы не подписали обращение',
            'subjectIIN.required' => 'Поле ИИН обязательно',
            'subjectName.required' => 'Поле ФИО обязательно',
//            'subjectIIN.exists' => 'Такого ИИН нету в нашей базе',
            'cert_date.required' => 'Поле Срок дейсвия обязательно',
        ];
    }
}
