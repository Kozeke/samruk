<div
    style="{{$editing!==2?"width: 50%; border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">
    @include('appeals_pdf_templates.appeal_header')

    <p dir="ltr" style="line-height:1.38;text-align: center;margin-top:12pt;margin-bottom:12pt;"><span
            style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;"> Полный досрочный выкуп за счет ЕПВ</span>
    </p>
    <p dir="ltr" style="line-height:1.38;margin-top:12pt;margin-bottom:12pt;"><span
            style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
    </p>
    <p dir="ltr" style="line-height:1.38;text-align: center;margin-top:12pt;margin-bottom:12pt;"><span
            style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">ЗАЯВЛЕНИЕ</span>
    </p>
    <p dir="ltr" style="line-height:1.38;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><span
            style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
    </p>
    <form action="{{ $editing?url('/view/appeal'):url('/edit/appeal') }}" method="post">
        {!! csrf_field() !!}

        <div dir="ltr" style="line-height:1.38;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Прошу Вас предоставить справку о задолженности в целях полного погашения остатка стоимости арендуемого мною жилого помещения, расположенного по адресу:&nbsp;</span><span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['JK']??""}}&nbsp;</span><span

                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;согласно условий Договора аренды с выкупом жилого помещения от&nbsp;</span><span
                style="font-size:12pt;color:#000000;background-color:transparent;font-weight:400;font-style:italic;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['date_d']??""}}</span><span

                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;года №&nbsp;</span><span
                style="font-size:12pt;color:#000000;background-color:transparent;font-weight:400;font-style:italic;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$id??""}}</span><span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">(далее &ndash; Договор), по состоянию на</span>

            @if($editing)
                <span style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['date_from']}}</span>
            @endif
            <input type="{{$editing?"hidden":"date"}}" name="date_from"
                   value="{{$data['date_from']??""}}"/>
            <span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">года</span>
            <span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">, за счет денежных средств ЕПВ (доступная сумма</span>
            @if($editing)
                <span style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['price']}}</span>
            @endif
            <input
                type="{{$editing?"hidden":"number"}}" name="price"
                value="{{$data['price']??""}}"/>
            <span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">тенге).</span>
            <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>
            <input type="hidden" name="editing" value="{{$editing??0}}"/>
        </div>
        @if($editing !== 2)
            <div style="position: absolute; top: 8px;left: 550px">

                @if($editing === 0)
                    <div style="position: absolute">
                        {{ Form::submit(trans('translations.gb.view')) }}
                    </div>
                @endif
                @if($editing === 1)
                    <div style="position: absolute">
                        {{ Form::submit(trans('translations.gb.edit'), ['class' => 'btn btn--secondary']) }}
                    </div>
                @endif
            </div>
    </form>
    <div style="position: absolute; top:8px; left: 705px">
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

    @include('appeals_pdf_templates.appeal_footer')

</div>
