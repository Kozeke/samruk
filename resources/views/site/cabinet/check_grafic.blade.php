@extends('site.cabinet.base_show')

@section('show_cabinet')

    <div class="title-page-wrap">
        <h2 class="title-page">График платежей</h2>

        @if ($grafic['code'] != 200)
            <a
                class="btn btn--primary btn--size-sm btn-docs"
                href="{{ route('cabinet.checkgrafic.pdf', ['id' => $id]) }}"
                target="_blank"
            >
                {!! icon('icon--download') !!}
                <span>Скачать PDF</span>
            </a>
        @endif
    </div>

    @if ($grafic['code'] != 200)
        <div class="alert alert--danger">{{ $grafic['message'] }}</div>
    @else
        <div class="formatted">
            <table>
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Дата платежа</th>
                        <th>Сумма платежа</th>
                        <th>Основной долг</th>
                        <th>Вознаграждение</th>
                        <th>Остаток основного долга</th>
                        <th>Цена продажи помещения, тенге</th>
                        @if($grafic['plateg'][0]['NDS'] != 0)
                            <th>НДС</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp

                    @foreach($grafic['plateg'] as $plateg)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ substr($plateg['ДатаПлатежа'], 0, 10) }}</td>
                            <td>{{ $plateg['platesh'] }}</td>
                            <td>{{ $plateg['osn_dolg'] }}</td>
                            <td>{{ $plateg['Vozn'] }}</td>
                            <td>{{ $plateg['Ost_osn_dolg'] }}</td>
                            <td>{{ $plateg['Ost_plateg'] }}</td>
                            @if($plateg['NDS'] != 0)
                                <td>{{ $plateg['NDS'] }}</td>
                            @endif
                        </tr>

                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection
