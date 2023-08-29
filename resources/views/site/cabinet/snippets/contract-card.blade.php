<div class="contract-card col-12 col-md-6 col-2xl-4">
    <div class="contract-card__inner">
        <h4 class="contract-card__header">Договор аренды №{{ $data['number'] }}</h4>

        <div class="contract-card__body">
            <ul class="contract-card__info">
                <li class="contract-card__info-item">
                    <div class="contract-card__info-group">
                        <span class="contract-card__info-label">Дата подписания договора</span>

                        @if (!empty($data['date_d']))
                            <time
                                class="contract-card__info-date"
                                datetime="{{ \Carbon\Carbon::parse($data['date_d'])->format('Y-m-d') }}"
                            >{{ \Carbon\Carbon::parse($data['date_d'])->format('d.m.Y') }}</time>
                        @else
                            <span class="contract-card__info-date">Не указана</span>
                        @endif
                    </div>
                </li>

                <li class="contract-card__info-item">
                    <div class="contract-card__info-label">Объект</div>

                    <div class="contract-card__info-text">
                        {{ $data['JK'] }} <br>
                        {{ $data['AdressJK'] }}
                        @if (!empty($data['Number_room']))
                            кв. {{ $data['Number_room'] }}
                        @endif
                    </div>
                </li>

                <li class="contract-card__info-item">
                    <div class="contract-card__info-label">Сумма к оплате Арендного платежа</div>

                    <div class="contract-card__info-group">
                        @if(!empty($data['plat_date']))
                            <span class="contract-card__info-label">Дата оплаты:</span>
                            <span class="contract-card__info-text">
                                {{ formatDate(\Carbon\Carbon::parse($data['plat_date'])->format('d M Y'), 'd M Y') }} г.
                            </span>
                        @else
                            <span class="contract-card__info-label">Не указана</span>
                        @endif
                    </div>

                    <div class="contract-card__info-group">
                        <span class="contract-card__info-label">Всего к оплате:</span>
                        <span class="contract-card__info-text">{{ $data['zad_plat'] }}</span>
                    </div>
                    <div class="contract-card__info-group">
                        <span class="contract-card__info-label">Задолженность по гарантийному платежу:</span>
                        <span class="contract-card__info-text">{{ $mainInfo['data']['gar_plat_dolg'] }}</span>
                    </div>
                    <div class="contract-card__info-group">
                        <span class="contract-card__info-label">Задолженность по пени:</span>
                        <span class="contract-card__info-text">{{ $mainInfo['data']['penya_ap_dolg'] }}</span>
                    </div>
                    <div class="contract-card__info-group">
                        <span class="contract-card__info-label">Задолженность по штрафу:</span>
                        <span class="contract-card__info-text">{{ $mainInfo['data']['penya_ap_dolg']  }}</span>
                    </div>
                    <div class="contract-card__info-group">
                        <span class="contract-card__info-label">Задолженность по возмещению имущественного налога:</span>
                        <span class="contract-card__info-text">{{ $data['zad_plat'] }}</span>
                    </div>
                    <div class="contract-card__info-group">
                        <span class="contract-card__info-label">Действующий договор:</span>
                        <span class="contract-card__info-text">отсутсвует</span>
                    </div>
                </li>
            </ul>

            <div class="contract-card__more">
                <a
                    class="btn btn--secondary"
                    href="{{ route('cabinet.show', ['id' => $data['number']]) }}"
                >Подробнее</a>
            </div>
        </div>
    </div>
</div>
