@extends('site.cabinet.base_show')

@section('show_cabinet')

    <h2 class="title-page">Уведомления</h2>

    <ul class="notifications">
        @if ($mainInfo['data']['gar_plat_dolg']==0)
                <li class="notifications__item">
                    <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>

                    <div class="notifications__item-info">
                        <div class="notifications__item-title">
                            О долге по ГП
                        </div>
                        <div class="notifications__item-desc">
                            Уважаемый {{$mainInfo['data']['FIO']}}, у вас имеется задолжность по ГП  в размере  - {{$mainInfo['data']['gar_plat_dolg']}} тг, просим Вас погасить в ближайшее время
                        </div>
                    </div>
                </li>
        @endif
            @if ($mainInfo['data']['plat_dolg']==0)
                <li class="notifications__item">
                    <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>

                    <div class="notifications__item-info">
                        <div class="notifications__item-title">
                            О долге по АП
                        </div>

                        <div class="notifications__item-desc">
                            Уважаемый {{$mainInfo['data']['FIO']}}, у вас имеется задолжность по АП  в размере  - {{$mainInfo['data']['plat_dolg']}} тг, просим Вас погасить в ближайшее время
                        </div>
                    </div>
                </li>
            @endif
            @if ($mainInfo['data']['penya_gp_dolg']==0)
                <li class="notifications__item">
                    <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>

                    <div class="notifications__item-info">
                        <div class="notifications__item-title">
                            О долге по пени ГП
                        </div>

                        <div class="notifications__item-desc">
                            Уважаемый {{$mainInfo['data']['FIO']}}, у вас имеется задолжность по пени гарантийного платежа  - {{$mainInfo['data']['penya_gp_dolg']}} тг, просим Вас погасить в ближайшее время
                        </div>
                    </div>
                </li>
            @endif
            @if ($mainInfo['data']['penya_gp_dolg']==0)
                <li class="notifications__item">
                    <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>

                    <div class="notifications__item-info">
                        <div class="notifications__item-title">
                            О долге по штрафам
                        </div>

                        <div class="notifications__item-desc">
                            Уважаемый {{$mainInfo['data']['FIO']}}, у вас имеется задолжность по штрафам в размере  - {{$mainInfo['data']['penya_ap_dolg']}} тг, просим Вас погасить в ближайшее время
                        </div>
                    </div>
                </li>
            @endif
            @if ($mainInfo['data']['im_nalog_dolg']==0)
                <li class="notifications__item">
                    <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>

                    <div class="notifications__item-info">
                        <div class="notifications__item-title">
                            О долге по возмещению имущественного налога
                        </div>

                        <div class="notifications__item-desc">
                            {{$mainInfo['data']['data_d']}}
                            {{\Carbon\Carbon::now()}}
                            Уважаемый {{$mainInfo['data']['FIO']}}, у вас имеется задолжность по возмещению имущественного налога  в размере  - {{$mainInfo['data']['im_nalog_dolg']}} тг, просим Вас погасить в ближайшее время
                        </div>
                    </div>
                </li>
            @endif
{{--        @if (!empty($spisanie_s_gp))--}}
{{--            @foreach ($spisanie_s_gp as $spisanie)--}}
{{--                <li class="notifications__item">--}}
{{--                    <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>--}}

{{--                    <div class="notifications__item-info">--}}
{{--                        <div class="notifications__item-title">--}}
{{--                            О списании с гарантийного платежа--}}
{{--                        </div>--}}

{{--                        <div class="notifications__item-desc">--}}
{{--                            {{ $spisanie['date_sp'] }} списано {{ $spisanie['Summa'] }} тг.--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </li>--}}
{{--            @endforeach--}}
{{--        @endif--}}

{{--        @if (!empty($notifications['data']['All_News']))--}}
{{--            @php--}}
{{--                $allNews = $notifications['data']['All_News']['News'];--}}

{{--                if (!isset($allNews[0]['date_News'])) {--}}
{{--                    $allNews = [];--}}
{{--                    $allNews[] = $notifications['data']['All_News']['News'];--}}
{{--                }--}}
{{--            @endphp--}}

{{--            @if (count($allNews) > 0)--}}
{{--                @foreach($allNews as $new)--}}
{{--                    <li class="notifications__item">--}}
{{--                        <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>--}}

{{--                        <div class="notifications__item-info">--}}
{{--                            <div class="notifications__item-title">Уведомление</div>--}}

{{--                            <div class="notifications__item-desc">--}}
{{--                                <b>Дата:</b>--}}
{{--                                {{ formatDate(\Carbon\Carbon::parse($new['date_News'])->format('d M Y'), 'd M Y') }} <br>--}}
{{--                                <b>Текст:</b>--}}
{{--                                {{ $new['text'] }}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--        @endif--}}
{{--        @if (isset($notifications['data']))--}}
{{--            @if ($notifications['data']['result'] == 4)--}}
{{--                <li class="notifications__item">--}}
{{--                    <div class="alert alert--danger m-0">--}}
{{--                        {{ $notifications['data']['comment'] }}--}}
{{--                    </div>--}}
{{--                </li>--}}
{{--            @else--}}
{{--                @if (!empty($notifications['data']['num_str'])&&$notifications['data']['date_k']>\Carbon\Carbon::now())--}}
                @if (isset($mainInfo['data']['data_d'])&&$mainInfo['data']['data_d']<\Carbon\Carbon::now())
                    <li class="notifications__item">
                        <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>

                        <div class="notifications__item-info">
                            <div class="notifications__item-title">
                                Страховка
                            </div>

                            <div class="notifications__item-desc">
                                <b>Номер страховки:</b>
{{--                                {{ $notifications['data']['num_str'] }} --}}
                                <br>
                                <b>Дата начала страховки:</b>
{{--                                {{ $notifications['data']['date_n'] }} --}}
                                <br>
                                <b>Дата окончания страховки:</b>
{{--                                {{ $notifications['data']['date_k'] }}--}}
                            </div>
                        </div>
                    </li>
                @else
                    <li class="notifications__item">
                        <div class="notifications__item-icon">{!! icon('icon--income') !!}</div>

                        <div class="notifications__item-info">
                            <div class="notifications__item-title">
                                {{ $notifications['data']['error_str'] }}
                            </div>
                        </div>
                    </li>
                @endif
{{--            @endif--}}
{{--            @endif--}}
    </ul>

    @if ($mainInfo['code'] == 500)
        <div class="alert alert--danger">Ошибка связи с сервером</div>
    @else
        <div style="margin-bottom: 2%; text-align: center">
        <h2>Информация по платежам арендатора</h2>
        </div>
        <div class="formatted">

            <table class="w-100">
                <thead>
                    <tr class="text-center">
                        <th></th>
                        <th>Переплата</th>
                        <th>Долг</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Гарантийный платеж</td>
                        <td> {{$mainInfo['data']['gar_plat_perep']}} </td>
                        <td> {{$mainInfo['data']['gar_plat_dolg']}} </td>
                    </tr>
                    <tr>
                        <td>Арендные платежи</td>
                        <td> {{$mainInfo['data']['plat_perep']}} </td>
                        <td> {{$mainInfo['data']['plat_dolg']}} </td>
                    </tr>
                    <tr>
                        <td>Начисленная пеня по арендным платежам</td>
                        <td> {{$mainInfo['data']['penya_ap_perep']}} </td>
                        <td> {{$mainInfo['data']['penya_ap_dolg']}} </td>
                    </tr>
                    <tr>
                        <td>Начисленная пеня по гарантийному платежу</td>
                        <td> {{$mainInfo['data']['penya_gp_perep']}} </td>
                        <td> {{$mainInfo['data']['penya_gp_dolg']}} </td>
                    </tr>
                    <tr>
                        <td>Возмещение налога на имущество</td>
                        <td> {{$mainInfo['data']['im_nalog_perep']}} </td>
                        <td> {{$mainInfo['data']['im_nalog_dolg']}} </td>
                    </tr>
                    <tr>
                        <td>Штраф</td>
                        <td> {{$mainInfo['data']['im_nalog_perep']}} </td>
                        <td> {{$mainInfo['data']['im_nalog_dolg']}} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

@endsection
