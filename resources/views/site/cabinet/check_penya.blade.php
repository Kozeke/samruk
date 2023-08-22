@extends('site.cabinet.base_show')

@section('show_cabinet')

    <h2 class="title-page">Сведения по пеням</h2>

    <ul class="notifications">
        <li class="notifications__item">
            <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>

            <div class="notifications__item-info">
                <div class="notifications__item-title m-0">
                    Задолженность по пеням составляет: {{ $data['Num_d']['penya'] }} тг.
                </div>
            </div>
        </li>
    </ul>

@endsection
