@extends('site.cabinet.base_show')

@section('show_cabinet')

    <h2 class="title-page">Сумма частично досрочного погашения</h2>

    @if (!is_null($chdp))
        @if ($chdp['data']['result'] == 0)
            <ul class="notifications">
                <li class="notifications__item">
                    <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>

                    <div class="notifications__item-info">
                        <div class="notifications__item-title m-0">
                            Сумма ежемесячного платежа будет составлять
                            {{ $chdp['data']['СуммаПлатежа'] }} тг.
                        </div>
                    </div>
                </li>
            </ul>
        @else
            <div class="alert alert--danger">{{ $chdp['data']['comment'] }}</div>
        @endif
    @endif

    @if (!is_null($error_chdp))
        <div class="alert alert--danger">{{ $error_chdp }}</div>
    @endif

    <form class="form-panel" action="{{ url('/cabinet/'.$id.'/check_chdp') }}">
        <div class="row row--sm">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    @php
                        $months_array = config('avl.months.' . app()->getLocale());
                        $now = \Carbon\Carbon::now();
                        $plus1 = \Carbon\Carbon::now()->addMonth();
                        $plus2 = \Carbon\Carbon::now()->addMonth(2);
                    @endphp

                    <div class="form-group__input">
                        <div class="select">
                            <select name="before_date">
                                <option
                                    value="{{ $now->format('d-m-Y') }}"
                                    @if($before_date == $now->format('d-m-Y')) selected @endif
                                >{{$months_array[$now->format('n')]}} {{$now->format('Y')}}</option>
                                <option
                                    value="{{ $plus1->format('d-m-Y') }}"
                                    @if($before_date == $plus1->format('d-m-Y')) selected @endif
                                >{{$months_array[$plus1->format('n')]}} {{$plus1->format('Y')}}</option>
                                <option
                                    value="{{ $plus2->format('d-m-Y') }}"
                                    @if($before_date == $plus2->format('d-m-Y')) selected @endif
                                >{{$months_array[$plus2->format('n')]}} {{$plus2->format('Y')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <div class="form-group__input">
                        <input
                            class="input"
                            type="text"
                            name="summa_chdp"
                            @if ($summa_chdp)
                                value="{{ $summa_chdp }}"
                            @endif
                            placeholder="Введите сумму погашения"
                        >
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-12">
                <div class="form-panel__actions">
                    <button class="btn btn--secondary" type="submit">Рассчитать</button>
                </div>
            </div>
        </div>
    </form>

@endsection
