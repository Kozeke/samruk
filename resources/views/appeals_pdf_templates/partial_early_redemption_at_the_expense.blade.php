<div
    style="{{$editing!==2?"width: 50%; border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">
    @include('appeals_pdf_templates.appeal_header')
    <p style="text-align: center;"><u><strong>Частично досрочное погашение за счет ЕПВ&nbsp;</strong></u></p>
    <p style="text-align: center;"><strong><u>ЗАЯВЛЕНИЕ</u></strong></p>
    <p>&nbsp;</p>
    <form action="{{ $editing?url('/view/appeal'):url('/edit/appeal') }}" method="post">

        <u>Прошу Вас предоставить справку о задолженности в целях частично досрочного погашения остатка стоимости
            арендуемого мною жилого помещения, расположенного по адресу: {{$data['JK']??""}}
            согласно условий Договора аренды с выкупом жилого помещения от {{$data['date_from']??""}} года № {{$id??""}}
            авто (далее
            &ndash; Договор), по состоянию на
            @if($editing)
                {{$data['date_from']}}
            @endif
            {!! csrf_field() !!}

            <input type="{{$editing?"hidden":"date"}}" name="date_from"
                   value="{{$data['date_from']??""}}"/> года, за счет
            денежных средств ЕПВ (доступная сумма
            <input type="{{$editing?"hidden":"number"}}" name="price"
                   value="{{$data['price']??""}}"/>
            @if($editing)
                {{$data['price']}} тенге).
            @endif
        </u>
        <div style="position: absolute; top: 8px;left: 550px">
            @if($editing !== 2)
                @if($editing === 0)
                    <div style="position: absolute">
                        {{ Form::submit(trans('translations.gb.view')) }}
                    </div>
                @elseif($editing === 1)
                    <div style="position: absolute">
                        {{ Form::submit(trans('translations.gb.edit'), ['class' => 'btn btn--secondary']) }}
                    </div>
                @endif
                <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>

    </form>
    <div style="position: absolute; top:-13px; left: 155px">
        <form action="{{url('/print/appeal')}}" method="post">`
            {!! csrf_field() !!}

            <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>
            <input type="hidden" name="date_from"
                   value="{{$data['date_from']??""}}"/>
            <input type="hidden" name="price"
                   value="{{$data['price']??""}}"/>

            {{ Form::submit(trans('translations.gb.print')) }}

        </form>
        @endif
    </div>
    <p><br></p>
</div>
@include('appeals_pdf_templates.appeal_footer')

