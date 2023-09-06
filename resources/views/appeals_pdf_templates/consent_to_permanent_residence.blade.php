<div
    style="{{$editing!==2?"width: 50%; border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">
    @include('appeals_pdf_templates.appeal_header')

    <p><span
        >Согласие на постоянную прописку</span>
    </p>
    <p><span
        >Заявление</span>
    </p>
    <p>
        <span>Прошу Вас дать согласие на регистрацию меня в Департаменте &quot;Центр обслуживания населения - филиала НАО &quot;Государственная корпорация &quot;Правительство для граждан&quot; по адресу:&nbsp;</span><span
        >авто</span>
    </p>
    <p><span>&nbsp;(Ф.И.О.)</span>
    </p>
    <p><strong>и членов моей семьи</strong></p>
    <span>1)</span>
    <span>@{{attachment_one}}</span>
    <input placeholder="(Ф.И.О., и степень родства)" type="text" v-model="attachment_one"/>
    <p>
    </p>
    <span>2)</span>
    <span>@{{attachment_two}}</span>
    <input placeholder="(Ф.И.О., и степень родства)" type="text" v-model="attachment_two"/>
    <p><span>на постоянное место жительство по адресу:&nbsp;</span><span>{{$data['JK']??""}}&nbsp;</span>
    <p><br>
    </p>

</div>
@include('appeals_pdf_templates.appeal_footer')

</div>
