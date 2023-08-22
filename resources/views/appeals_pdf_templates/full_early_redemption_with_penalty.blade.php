<div
    style="{{$editing!==2?"width:50%;border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">

    @include('appeals_pdf_templates.appeal_header')

    <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
    <p style="text-align: center"><strong><u>Полный досрочный выкуп со
                списанием пени в размере 90%</u></strong></p>
    <p>&nbsp;</p>
    <p style="text-align: center;"><strong><u>ЗАЯВЛЕНИЕ</u></strong></p>
    <p>&nbsp;</p>
    <form action="{{ $editing?url('/view/appeal'):url('/edit/appeal') }}" method="post">
        <u>Прошу Вас разрешить произвести полный досрочный выкуп с возможностью списания 90% начисленной пени
            арендуемого
            мною помещения, расположенного по адресу: {{$data['JK']??""}} согласно условий Договора
            аренды с выкупом от {{$data['data_d']??""}} года № {{$id??""}}, до периода</u>
        @if($editing)
            {{$data['date_from']}} года.
        @endif
        <input type="{{$editing?"hidden":"date"}}" name="date_from" value="{{$data['date_from']??""}}">
        <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>
        <input type="hidden" name="editing" value="{{$editing??0}}"/>
        {!! csrf_field() !!}

        <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <u>В случае неосуществления мной оплаты остатка стоимости помещения до
                периода</u>
            <input type="{{$editing?"hidden":"date"}}" name="date_to" value="{{$data['date_to']??""}}">

            @if($editing)
                {{$data['date_to']}}
            @endif
            года, <u>прошу аннулировать данное заявление (оставить без рассмотрения).</u></p>

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
            <input type="hidden" name="date_to"
                   value="{{$data['date_to']??""}}"/>

            {{ Form::submit(trans('translations.gb.print')) }}

        </form>
        @endif
    </div>
    <p><br></p>
    <p><br></p>
</div>
@include('appeals_pdf_templates.appeal_footer')
