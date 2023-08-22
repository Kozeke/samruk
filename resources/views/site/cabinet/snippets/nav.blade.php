<div class="cabinet__aside-item second-nav">
    <ul class="second-nav__list">
        <li>
            <a
                href="{{ route('cabinet.checkakt', ['id' => $id]) }}"
                target="_blank"
            >Справка по платежам</a>
        </li>
        <li>
            <a
                class="{{ Route::is('cabinet.checkgrafic') ? 'is-active' : ''}}"
                href="{{ route('cabinet.checkgrafic', ['id' => $id]) }}"
            >График платежей</a>
        </li>
        <li>
            <a
                class="{{ Route::is('cabinet.checkchdp') ? 'is-active' : ''}}"
                href="{{ route('cabinet.checkchdp', ['id' => $id]) }}"
            >Расчет частично досрочного погашения</a>
        </li>
        <li>
            <a
                class="{{ Route::is('cabinet.checkpv') ? 'is-active' : ''}}"
                href="{{ route('cabinet.checkpv', ['id' => $id]) }}"
            >Расчет полного досрочного выкупа</a>
        </li>
        <li>
            <a
                class="{{ Route::is('cabinet.show') ? 'is-active' : ''}}"
                href="{{ route('cabinet.show', ['id' => $id]) }}"
            >Уведомления</a>
        </li>
        <li>
            <a
                class="{{ Route::is('cabinet.feedback') ? 'is-active' : ''}}"
                href="{{ route('cabinet.feedback', ['id' => $id]) }}"
            >Мои обращение</a>
        </li>
    </ul>
</div>
