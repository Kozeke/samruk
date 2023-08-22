<div
    style="{{$editing!==2?"width: 50%; border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">
    @include('appeals_pdf_templates.appeal_header')

    <p style="text-align: center;"><strong>Расторжение договора</strong></p>
    <p>&nbsp;</p>
    <p style="text-align: center;"><strong>ЗАЯВЛЕНИЕ</strong></p>
    <p>&nbsp;</p>
    <form action="{{ $editing?url('/view/appeal'):url('/edit/appeal') }}" method="post">
        {!! csrf_field() !!}

        В связи с
        @if($editing)
            <span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['reason']??""}}</span>
        @endif
        <input
            style="width: 70%" type="{{$editing?"hidden":"text"}}" name="reason"
            value="{{$data['reason']??""}}"/>

        <p> прошу Вас расторгнуть Договор аренды с выкупом жилого помещения от {{$data['data_d']??""}} года
            № {{$id??""}} авто (далее &ndash; Договор) согласно утвержденной процедуре.</p>
        <p dir="ltr" style="line-height:1.3800000000000001;margin-top:12pt;margin-bottom:12pt;"><br></p>
        <p dir="ltr" style="line-height:1.3800000000000001;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><br>
        </p>
        <p>&nbsp;</p>
        <p dir="ltr" style="line-height:1.38;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><br></p>
        <p><br></p>
        <p><br></p>
        <p><br></p>
        <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>
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
            
            <input type="hidden" name="reason"
                   value="{{$data['reason']??""}}"/>

            {{ Form::submit(trans('translations.gb.print')) }}

        </form>
        @endif
    </div>
    @include('appeals_pdf_templates.appeal_footer')

</div>
