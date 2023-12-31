<div
    style="{{$editing!==2?"width: 50%; border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">
    @include('appeals_pdf_templates.appeal_header')

    <p dir="ltr" style="line-height:1.38;text-align: center;margin-top:12pt;margin-bottom:12pt;"><span
            style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Согласие на передачу в субаренду</span>
    </p>
    <p dir="ltr" style="line-height:1.38;margin-top:12pt;margin-bottom:12pt;"><span
            style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;</span>
    </p>
    <p dir="ltr" style="line-height:1.38;text-align: center;margin-top:12pt;margin-bottom:12pt;"><span
            style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">ЗАЯВЛЕНИЕ</span>
    </p>

        <p dir="ltr" style="line-height:1.3800000000000001;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><span
                style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Прошу Вас разрешить сдать в субаренду арендуемое мною жилое помещение, расположенное по адресу&nbsp;</span><span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['JK']??""}}&nbsp;</span><span
                style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">, &nbsp;согласно условий Договора аренды с выкупом жилого помещения от&nbsp;</span><span
                style="font-size:12pt;color:#000000;background-color:transparent;font-weight:400;font-style:italic;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['date_d']??""}}</span><span
                style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;№&nbsp;</span><span
                style="font-size:12pt;color:#000000;background-color:transparent;font-weight:400;font-style:italic;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$id??""}}</span><span
                style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;в связи с&nbsp;</span>
        </p>
            <span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['reason']}}</span>
        <input style="width: 80%" type="{{$editing?"hidden":"text"}}" name="reason"
               value="{{$data['reason']??""}}"/>
        <p></p>
        <span dir="ltr"
              style="line-height:1.3800000000000001;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><span
                style="font-size:13.999999999999998pt;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Прилагается:</span>
        </span>
        <p></p>
        <span dir="ltr"
              style="font-size:13.999999999999998pt;line-height:1.3800000000000001;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;">1)</span>
            <span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['attachment_one']??""}}</span>
        <input
            style="width: 70%" type="{{$editing?"hidden":"text"}}" name="attachment_one"
            value="{{$data['attachment_one']??""}}"/>
        <p>
        </p>
        <span dir="ltr"
              style="font-size:13.999999999999998pt;line-height:1.3800000000000001;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;">2)</span>
            <span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{$data['attachment_two']??""}}</span>
        <input
            style="width: 70%" type="{{$editing?"hidden":"text"}}" name="attachment_two"
            value="{{$data['attachment_two']??""}}"/>
        <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>


            </div>

    </div>
    @include('appeals_pdf_templates.appeal_footer')

</div>
