<div
    style="{{$editing!==2?"width: 50%; border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">
    @include('appeals_pdf_templates.appeal_header')

    <p style="text-align: center; font-size: 18px"><strong>Расторжение договора</strong></p>
    <p>&nbsp;</p>
    <p style="text-align: center; font-size: 18px"><strong>ЗАЯВЛЕНИЕ</strong></p>
    <p>&nbsp;</p>

        В связи с
            <span>{{$data['reason']??""}}</span>
        <input
            style="width: 70%" type="text" name="reason"/>

        <p> прошу Вас расторгнуть Договор аренды с выкупом жилого помещения от {{$data['data_d']??""}} года
            № {{$id??""}} авто (далее &ndash; Договор) согласно утвержденной процедуре.</p>
        <p  style="line-height:1.3800000000000001;margin-top:12pt;margin-bottom:12pt;"><br></p>
        <p  style="line-height:1.3800000000000001;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><br>
        </p>
        <p>&nbsp;</p>
        <p  style="line-height:1.38;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><br></p>
        <p><br></p>
        <p><br></p>
        <p><br></p>
    </div>
    @include('appeals_pdf_templates.appeal_footer')

</div>
