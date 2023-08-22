<div
    style="{{$editing!==2?"width: 50%; border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">
    @include('appeals_pdf_templates.appeal_header')
    <p dir="ltr" style="line-height:1.38;text-align: center;margin-top:12pt;margin-bottom:12pt;"><span
            style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;"> Справка о всех поступивших платежах</span>
    </p>
    <p dir="ltr" style="line-height:1.38;margin-top:12pt;margin-bottom:12pt;"><span
            style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>

    <form action="{{ $editing?url('/view/appeal'):url('/edit/appeal') }}" method="post">
        {!! csrf_field() !!}

        <div dir="ltr" style="line-height:1.38;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">
    Настоящим прошу Вас предоставить справку о всех поступивших платежах по Договору  аренды с выкупом от {{$data['data_d']??""}} г. &nbsp;№ {{$id??""}}.&nbsp;</span>
        </div>
    <p dir="ltr" style="line-height:1.38;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><br></p>

    <p><br></p>
    </form>
    @if($editing !== 2)

    <div style="position: absolute; top:8px; left: 705px">
        <form action="{{url('/print/appeal')}}" method="post">`
            {!! csrf_field() !!}

            <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>


            {{ Form::submit(trans('translations.gb.print')) }}

        </form>
    </div>
    @endif
    @include('appeals_pdf_templates.appeal_footer')

</div>
