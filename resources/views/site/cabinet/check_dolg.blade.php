@extends('site.cabinet.base_show')

@section('show_cabinet')

    <h2 class="title-page">Задолженность по договору</h2>

    <ul class="notifications">
        <li class="notifications__item">
            <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>

            <div class="notifications__item-info">
                <div class="notifications__item-title m-0">
                    Задолженность по договору составляет: {{ $data['Num_d']['sum_d'] }} тг.
                </div>
            </div>
        </li>
    </ul>

@endsection
