<div
    style="{{$editing!==2?"width: 50%; border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">
    @include('appeals_pdf_templates.appeal_header')
    <div style="font-size: 12px">
        <p style=" text-align: center"><strong>Полный досрочный выкуп</strong></p>
        <p>&nbsp;</p>
        <p style="text-align: center;">
            <strong>ЗАЯВЛЕНИЕ</strong></p>
        <p>&nbsp;</p>
        Прошу Вас разрешить произвести полный досрочный выкуп арендуемого мною жилого помещения, расположенного по
        адресу: {{$address??""}}, ЖК {{$residential_complex??""}}, дом {{$house??""}}, квартира {{$appartment??""}}
        согласно условий Договора аренды с выкупом жилого помещения от
        {{$data['date_to']??""}} года № {{$contract_number??""}} (далее &ndash; Договор), по
        состоянию на
        @if($editing)
            {{$data['date_from']}} года.
        @endif
        <form action="{{ $editing?url('/view/appeal'):url('/edit/appeal') }}" method="post">
            {!! csrf_field() !!}


            <input type="{{$editing?"hidden":"date"}}" name="date_from"
                   value="{{$data['date_from']??""}}"/>
            &nbsp;</p>
            <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>
            <input type="hidden" name="editing" value="{{$editing??0}}"/>
            <p><br></p>
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

        </form>
        <div style="position: absolute; top:-13px; left: 155px">
            <form action="{{url('/print/appeal')}}" method="post">`
                {!! csrf_field() !!}

                <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>
                <input type="hidden" name="date_from"
                       value="{{$data['date_from']??""}}"/>

                {{ Form::submit(trans('translations.gb.print')) }}

            </form>
            @endif
        </div>
    </div>
</div>
@include('appeals_pdf_templates.appeal_footer')
