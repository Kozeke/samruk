<div
    style="width: 50%; border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke">
    @include('appeals_pdf_templates.appeal_header')
    <p> Справка о всех поступивших платежах</p>
    <p></p>
        <div dir="ltr" style="line-height:1.38;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><span
                style="font-size:13.999999999999998pt;;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">
    Настоящим прошу Вас предоставить справку о всех поступивших платежах по Договору  аренды с выкупом от {{$data['data_d']??""}} г. &nbsp;№ {{$id??""}}.&nbsp;</span>
        </div>
    <p dir="ltr" style="line-height:1.38;text-indent: 35pt;margin-top:12pt;margin-bottom:12pt;"><br></p>

    <p><br></p>


    @include('appeals_pdf_templates.appeal_footer')

</div>
