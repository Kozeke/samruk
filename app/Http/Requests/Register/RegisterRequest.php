<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'subjectName' => 'required|max:255',
            'subjectIIN' => 'required|unique:users,iin',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'unique:users,mobile|min:18',
            'password' => 'required|min:5|max:200',
            'work_phone' => 'min:18',
            'home_phone' => 'min:18',
        ];
    }

    public function messages()
    {
        return [
            'subjectName.required' => 'Поле Фамилия Имя обязательно к заполнению',
            'subjectIIN.required' => 'Поле ИИН обязательно к заполнению',
            'subjectIIN.unique' => 'Пользователь с таким ИИН уже зарегистрирован',
            'email.required' => 'Поле E-mail обязательно к заполнению',
            'email.unique' => 'Пользователь с таким E-mail уже зарегистрирован',
            'mobile.unique' => 'Пользователь с таким Телефоном уже зарегистрирован',
            'password.required' => 'Пароль не заполнен.',
            'work_phone.min' => 'Рабочий телефон не заполнен',
            'home_phone.min' => 'Домашний телефон не заполнен',
            'mobile.min' => 'Телефон не заполнен',
        ];
    }
}
