@extends('site.cabinet.base_show')

@section('show_cabinet')

    <h2 class="title-page">Сумма полного досрочного выкупа</h2>

    @if ($pv['data']['result'] == 0)
        <ul class="notifications">
            <li class="notifications__item">
                <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>

                <div class="notifications__item-info">
                    <div class="notifications__item-title m-0">
                        Сумма полного досрочного выкупа составит {{ $pv['data']['СуммаПлатежа'] }} тг.
                    </div>
                </div>
            </li>
        </ul>
    @else
        <div class="alert alert--danger">{{ $pv['data']['comment'] }}</div>
    @endif

    <form class="form-panel" action="{{ url('/cabinet/'.$id.'/check_pv') }}">
        <div class="row row--sm">
            <div class="col-12">
                <div class="form-group">
                    @php
                        $months_array = config('avl.months.' . LaravelLocalization::getCurrentLocale());
                        $now = \Carbon\Carbon::now();
                        $plus1 = \Carbon\Carbon::now()->addMonth();
                        $plus2 = \Carbon\Carbon::now()->addMonth(2);
                    @endphp

                    <div class="form-group__input">
                        <div class="select">
                            <select name="before_date">
                                <option value="{{ $now->format('d-m-Y') }}" @if($before_date == $now->format('d-m-Y')) selected @endif>{{$months_array[$now->format('n')]}} {{$now->format('Y')}}</option>
                                <option value="{{ $plus1->format('d-m-Y') }}" @if($before_date == $plus1->format('d-m-Y')) selected @endif>{{$months_array[$plus1->format('n')]}} {{$plus1->format('Y')}}</option>
                                <option value="{{ $plus2->format('d-m-Y') }}" @if($before_date == $plus2->format('d-m-Y')) selected @endif>{{$months_array[$plus2->format('n')]}} {{$plus2->format('Y')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="form-panel__actions">
                    <button class="btn btn--secondary" type="submit">Рассчитать</button>
                </div>
            </div>
        </div>
    </form>

@endsection
