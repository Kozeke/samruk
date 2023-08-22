<div class="cabinet__aside-item contract-payment">
    <div class="contract-payment__item">
        <div class="contract-payment__title">
            Цена приобретения
        </div>

        <div class="contract-payment__amount">
            {{ $data['sum_d'] }} <span>тенге</span>
        </div>
    </div>

    <div class="contract-payment__item">
        <div class="contract-payment__title">
            Ежемесячный арендный платеж
        </div>

        <div class="contract-payment__amount">
            {{ $data['plat_d'] }} тенге
        </div>
    </div>

    <div class="contract-payment__item">
        <div class="contract-payment__title">
            Сумма гарантийного платежа по договору
        </div>

        <div class="contract-payment__amount">
            @if(!empty($data['gar_plat_by_dog']))
                {{ $data['gar_plat_by_dog'] }} тенге
            @else
                Не указана
            @endif
        </div>
    </div>
</div>
