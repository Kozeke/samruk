<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'custom' => [
        'role_name' => [
            'required' => 'Поле <b>Имя</b> обязательно к заполнению',
            'regex' => 'В имени должны быть только символы английского языка.',
            'unique' => 'Роль <b>:input </b> уже была добавлена ранее'
        ],
        'role_display_name' => [
            'required' => 'Поле обязательно к заполнению',
            'min' => 'Длина <b>:input</b> менее :min символов'
        ],

        'lang_name' => [
            'required' => 'Поле обязательно к заполнению',
            'min' => 'Длина <b>:input</b> менее :min символов'
        ],

        'profile_iin' => [
          'required' => 'Поле <b>ИИН</b> обязательно к заполнению',
          'size' => 'Введите корректный ИИН: не менее :size символов',
          'numeric' => 'ИИН может быть только числом'
        ],
        'profile_email' => [
          'required' => 'Поле <b>E-Mail</b> обязательно к заполнению',
          'email' => 'Введите корректный E-Mail',
          'unique' => 'Данный E-mail уже зарегистрирован',
        ],
        'profile_dob' => [
          'required' => 'Поле <b>Дата рождения</b> обязательно к заполнению',
          'size' => 'Введите корректную Дату рождения'
        ],
        'profile_fio' => [
          'required' => 'Поле <b>ФИО</b> обязательно к заполнению',
          'min' => 'Введите корректные ФИО: не менее :min символов',
          'max' => 'Введите корректные ФИО: не более :max символов'
        ],
        'profile_sex' => [
          'required' => 'Поле <b>Пол</b> обязательно к заполнению',
          'max' => 'Выберите пол',
          'numeric' => 'Выберите корректно ПОЛ'
        ],
        'profile_password' => [
          'required' => 'Поле <b>Пароль</b> обязательно к заполнению',
          'min' => 'Пароль не менее :min символов',
        ],
        'profile_photo' => [
          'required' => 'Выберите <b>ФОТО</b>'
        ],
        'profile_roles' => [
          'required' => 'Роль для пользователя не выбрана',
          'min' => 'Роль для пользователя не выбрана'
        ],

        /* Templates */
        'template_name' => [
          'required' => 'Название шаблона не заполнено',
          'min' => 'Название шаблона должно быть не менее :min символов.'
        ],
        'template_template' => [
          'required' => 'Тип шаблона не выбран',
          'regex' => 'Тип шаблона должен иметь только английские символы'
        ],
        'template_records' => [
          'required' => 'Кол-во записей на странице не заполнено',
          'integer' => 'Кол-во записей на странице не число'
        ],
        'template_records_col' => [
          'required' => 'Кол-во записей в колонке не заполнено',
          'integer' => 'Кол-во записей в колонке не число'
        ],
        'template_file_short' => [
          'required' => 'Шаблон для вывода короткой записи - не выбран',
          'not_in' => 'Шаблон для вывода короткой записи - не выбран'
        ],
        'template_file_full' => [
          'required' => 'Шаблон для вывода полной записи - не выбран',
          'not_in' => 'Шаблон для вывода полной записи - не выбран'
        ],
        'template_file_col' => [
          'required' => 'Шаблон для вывода вывода колонки - не выбран',
          'not_in' => 'Шаблон для вывода вывода колонки - не выбран'
        ],
        'template_file_category' => [
          'required' => 'Шаблон для вывода категории - не выбран',
          'not_in' => 'Шаблон для вывода категории - не выбран'
        ],

        /* News*/
        'news_title_ru' => [
          'required' => 'Заголовок не заполнен'
        ],
        'news_published_at' => [
          'required' => 'Выберите дату публикации'
        ],

        /* Section*/
        'section_name_ru' => [
          'required' => 'Заголовок не заполнен',
          'min' => 'Название не менеее :min символов',
          'max' => 'Название не более :max символов'
        ],
        'section_type' => [
          'required' => 'Выберите тип раздела',
          'min' => 'Выберите тип раздела'
        ],
        'section_template' => [
          'required' => 'Выберите шаблон раздела'
        ],
        'section_good' => [
          'numeric' => 'Good должно быть числовое выражение'
        ],
        'section_menu' => [
          'numeric' => 'Menu должно быть числовое выражение'
        ],
        'section_parent' => [
          'required' => 'Выберите добавить в'
        ],
        'section_alias' => [
          'required' => 'Введите Алиас',
          'min' => 'Алиас не менее :min',
          'max' => 'Алиас не более :max',
          'unique' => 'Алиас должен быть уникальным'
        ],

        /* auth */
        'email' => [
          'required' => 'E-mail не заполнен',
          'exists' => 'Қолданушы табылған жоқ',
        ],
        'password' => [
          'required' => 'Құпия сөз толтырылған жоқ',
          // 'exists' => 'Пользователь не найден',
        ],

        /* Registrations */
        'registrations_iin' => [
          'required' => 'ЖШН толтырылған жоқ',
          'regex' => 'ЖШН дұрыс терілген жоқ',
          'unique' => 'ЖШН тіркелген',
        ],
        'registrations_name' => [
          'required' => 'Атыңыз толтырылған жоқ',
          'max' => 'Максималды :max таңба',
        ],
        'registrations_surname' => [
          'required' => 'Тегіңіз толтырылған жоқ',
          'max' => 'Максималды :max таңба',
        ],
        'registrations_patronymic' => [
          'required' => 'Әкеңіздің аты толтырылған жоқ',
          'max' => 'Максималды :max таңба',
        ],
        'registrations_email' => [
          'required' => 'Толтыруға міндетті жол',
          'email' => 'E-mail дұрыс терілген жоқ',
          'unique' => 'E-mail тіркелген',
          'exists' => 'E-mail табылмады',
        ],
        'registrations_adds' => [
          'required' => 'Мекен-жай толтырылған жоқ',
          'max' => 'Максималды :max таңба',
        ],
        'registrations_phone' => [
          'required' => 'Үй телефоны толтырылған жоқ',
          'max' => 'Максималды :max таңба',
        ],
        'registrations_mobile' => [
          'required' => 'Ұялы телефон толтырылған жоқ',
          'max' => 'Максималды :max таңба',
        ],
        'registrations_password' => [
          'required' => 'Құпия сөз толтырылған жоқ',
          'min' => 'Минималды :min таңба',
          'max' => 'Максималды :max таңба',
        ],
        'registrations_confirm' => [
          'required' => 'Құпия сөзді растаңыз',
          'same' => 'Құпия сөздер сәйкес келмеді',
        ],
    ]

];
