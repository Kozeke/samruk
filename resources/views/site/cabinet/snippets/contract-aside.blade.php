<div class="cabinet__aside-item contract-aside">
    <div class="contract-aside__title">
        {!! icon('icon--document') !!}
        <span>
            Договор аренды <br>
            №{{ $id }}
        </span>
    </div>

    <div class="contract-aside__text">
        Объект {{ $data['AdressJK'] }}
        @if (!empty($data['Number_room']))
            кв. {{ $data['Number_room'] }}
        @endif
    </div>
</div>

