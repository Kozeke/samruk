<h4>Здравствуйте, {{ $user->name }}!</h4>
<p>Вы получили данное письма так как запросили восстановление пароля на сайте skcn.kz.</p>

<p>Для продолжения вам необходимо пройти по <a
        href="https://skcn.kz/ru/registrations/restore/verify-{{ $user->verify }}">ссылке</a>, либо скопировать и
    вставить в браузер следующую строку:</p>
<p><a href="https://skcn.kz/ru/registrations/restore/verify-{{ $user->verify }}">https://skcn.kz/ru/registrations/restore/verify-{{ $user->verify }}</a>
</p>

<p>Если это были не вы, то просто проигнорируйте данное письмо.</p>
