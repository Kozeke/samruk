<div class="cabinet__header">
    <ul class="profile">
        <li class="profile__item profile__item--home">
            <a
                class="profile__link-home link"
                href="{{ route('cabinet.index') }}"
            >{!! icon('icon--home') !!}</a>
        </li>

        <li class="profile__item">
            <span class="profile__label">ФИО</span>
            <span class="profile__text">{{ $user->name }}</span>
        </li>

        <li class="profile__item">
            <span class="profile__label">ИИН</span>
            <span class="profile__text">{{ $user->iin }}</span>
        </li>

        <li class="profile__item">
            <span class="profile__label">email</span>
            <span class="profile__text">{{ $user->email }}</span>
        </li>
        <li style="margin-left: 10%" class="profile__item">
            <strong><a
                    class="profile__label {{ Route::is('cabinet.settings') ? 'is-active' : ''}}"
                    href="{{ route('cabinet.settings') }}"
                >Настройки</a></strong>
        </li>

        <li class="profile__item">
            <strong><a href="#" class="profile__label">Часто-задаваемые вопросы</a></strong>

        </li>
        <li class="profile__item profile__item--exit">
            <a
                class="profile__link-exit link"
                href="{{ route('auth.logout') }}"
            >
                {!! icon('icon--exit') !!}
                <span>Выход</span>
            </a>
        </li>
    </ul>
    @if(isset($showNotification)&&$showNotification)
    <div class="formatted">
        <ul>
            <li>Личный кабинет работает в тестовом режиме</li>

            @include('site.cabinet.snippets.questionnaire')
        </ul>
    </div>
    @endif
</div>
