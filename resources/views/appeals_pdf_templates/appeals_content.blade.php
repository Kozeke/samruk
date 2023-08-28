<head>
    <style>
        .content {
            color: black;
            font-size: 16px;
            font-weight: 500;
        }

        .page {
            border: 1px solid black;
            margin: 3%;
            padding: 2%;
            border-radius: 2px;
            background-color: whitesmoke
        }

        .appeal-text {
            text-indent: 45px
        }
    </style>
</head>
<div v-if="selected_code_id">
    <div style="display: inline-flex">
        <div>

            <div v-if="!lock_inputs">
                <button type="button" href="#" class="btn btn--secondary" v-on:click="lockInputs">Посмотреть
                </button>
            </div>
            <div v-else style="">
                <button type="button" href="#" class="btn btn--secondary" v-on:click="lockInputs">
                    Отредактировать
                </button>
            </div>
        </div>
        <div style="position: relative; left: 15%">
            <button type="button" href="#" class="btn btn--secondary" v-on:click="printPdf">Печать
            </button>
        </div>
        <div style="position: relative; left: 75%">
            <button type="button" href="" class="btn btn--secondary" v-on:click="sendAppealTemplate">Отправить
            </button>
        </div>
    </div>

<div class="page">

    @include('appeals_pdf_templates.appeal_header')

    <div v-if="selected_code_id==1" class="content">
        <p><br></p>
        <p style="font-size: 18px; text-align: center"><strong>Частично досрочное погашение</strong></p>
        <p><strong>&nbsp;</strong></p>
        <p style="font-size: 18px; text-align: center"><strong>ЗАЯВЛЕНИЕ</strong></p>
        <p>&nbsp;</p>
        <p class="appeal-text">Настоящим прошу Вас разрешить внести на частично досрочное погашение сумму в
            размере
            <span v-if="lock_inputs">
                @{{price}}
            </span>
            <span v-if="!lock_inputs">
                <input v-model="price" type="number"/>
            </span> тенге по Договору аренды с выкупом жилого помещения от {{$data['date_d']??""}} года
            &nbsp;№{{$id??""}}, на
            <span v-if="lock_inputs">
                @{{date_to_finish}}
            </span>
            <span v-if="!lock_inputs">
                <input v-model="date_to_finish" type="date"/>
            </span>
    </div>
    <div v-if="selected_code_id==2" class="content">
        <p><br></p>
        <p style="font-size: 18px; text-align: center"><strong>Полный досрочный выкуп</strong></p>
        <p>&nbsp;</p>
        <p style="font-size: 18px; text-align: center">
            <strong>ЗАЯВЛЕНИЕ</strong></p>
        <p class="appeal-text">&nbsp;
        Прошу Вас разрешить произвести полный досрочный выкуп арендуемого мною жилого помещения, расположенного
        по адресу: {{$data['JK']??""}}согласно условий Договора аренды с выкупом жилого помещения от
        {{$data['date_d']??""}} года № {{$id??""}} (далее &ndash; Договор), по состоянию на

        <span v-if="lock_inputs">
            @{{date_to_finish}} года.
        </span>
        <span v-if="!lock_inputs">
            <input type="date" v-model="date_to_finish"/>
        </span>
        </p>
        <p><br></p>
    </div>

    <div v-if="selected_code_id==3" class="content">
        <div>
            <p><br></p>
            <p style="font-size: 18px; text-align: center">
                <strong>Полный досрочный выкуп со списанием пени в размере 90%</strong></p>
            <p>&nbsp;</p>
            <p style="font-size: 18px; text-align: center"><strong>ЗАЯВЛЕНИЕ</strong></p>
            <p class="appeal-text">&nbsp;
                Прошу Вас разрешить произвести полный досрочный выкуп с возможностью списания
                90% начисленной пени арендуемого мною помещения, расположенного по адресу: {{$data['JK']??""}} согласно
                условий Договора аренды с выкупом от {{$data['date_d']??""}} года № {{$id??""}}, до периода
                <span v-if="lock_inputs">
                @{{date_to_finish}}
            </span>
                <span v-if="!lock_inputs">
                <input type="date" v-model="date_to_finish">
            </span>
                В случае неосуществления мной оплаты остатка стоимости помещения до периода
                <span v-if="lock_inputs">
                    @{{date_to}}
                </span>
                <span v-if="!lock_inputs">
                    <input type="date" v-model="date_to">
                </span>
                года, прошу аннулировать данное заявление (оставить без рассмотрения).</p>
        </div>
    </div>
    <div v-if="selected_code_id==5" class="content">
        <p><br></p>
        <p style="font-size: 18px; text-align: center">
            <strong>Полный досрочный выкуп за счет ЕПВ</strong>
        </p>
        <p><span>&nbsp;</span></p>
        <p style="font-size: 18px; text-align: center"><strong>ЗАЯВЛЕНИЕ</strong></p>
        <p class="appeal-text">
            Прошу Вас предоставить справку о задолженности в целях полного погашения остатка стоимости арендуемого мною жилого помещения, расположенного по адресу: {{$data['JK']??""}}
            согласно условий Договора аренды с выкупом жилого помещения от {{$data['date_d']??""}} года №{{$id??""}} (далее &ndash; Договор), по состоянию на
            <span v-if="lock_inputs">@{{date_from}}</span>
            <span v-else><input type="date" name="date_from"
                                v-model="date_from"/>
            </span> года за счет денежных средств ЕПВ (доступная сумма
        <span v-if="lock_inputs">@{{price}}</span>
        <span v-else>
            <input type="number" v-model="price">
        </span> тенге).</p>
    </div>
    <div v-if="selected_code_id==4" class="content">
        <p><br></p>
        <p style="font-size: 18px; text-align: center"><strong>Частично досрочное погашение за счет ЕПВ&nbsp;</strong></p>
        <p>&nbsp;</p>
        <p style="font-size: 18px; text-align: center"><strong>ЗАЯВЛЕНИЕ</strong></p>
        <p style="text-indent: 45px">Прошу Вас предоставить справку о задолженности в целях частично досрочного погашения остатка стоимости
        арендуемого мною жилого помещения, расположенного по адресу: {{$data['JK']??""}}
        согласно условий Договора аренды с выкупом жилого помещения от {{$data['date_from']??""}} года № {{$id??""}}
        авто (далее &ndash; Договор), по состоянию на
        <span v-if="lock_inputs">
            @{{date_to_finish}}
        </span>
        <span v-else>
            <input type="date" v-model="date_to_finish"/>
        </span> года, за счет денежных средств ЕПВ (доступная сумма
        <span v-if="lock_inputs">
            @{{price}}
        </span>
        <span v-else>
            <input type="number" v-model="price" name="price"/>
        </span> тенге). </p>
        <p><br></p>
    </div>
    <div v-if="selected_code_id==6" class="content">
        <p><br></p>
        <p style="font-size: 18px; text-align: center"><strong>Справка о всех поступивших платежах</strong></p>
        <p>&nbsp;</p>
        <p class="appeal-text">Настоящим прошу Вас предоставить справку о всех поступивших платежах по Договору аренды с выкупом
            от {{$data['date_d']??""}} г. &nbsp;№{{$id??""}}.&nbsp;</p>
        <p><br></p>
        <p><br></p>
    </div>
    <div v-if="selected_code_id==7" class="content">
        <p><br></p>
        <p style="font-size: 18px; text-align: center"><strong>Согласие на передачу в субаренду</strong>
        </p>
        <p><span>&nbsp;</span>
        </p>
        <p style="font-size: 18px; text-align: center"><strong> ЗАЯВЛЕНИЕ</strong>
        </p>
        <p class="appeal-text">Прошу Вас разрешить сдать в субаренду арендуемое мною жилое помещение, расположенное по адресу
            {{$data['JK']??""}}, согласно условий Договора аренды с выкупом жилого помещения от {{$data['date_d']??""}}
            №{{$id??""}} в связи с
        </p>
        <span v-if="lock_inputs">@{{reason}}</span>
        <span v-else>
            <input type="text" v-model="reason"/>
        </span>
        <p></p>
        <span>Прилагается:</span>
        <p></p>
        <span>1)</span>
        <span v-if="lock_inputs">@{{attachment_one}}</span>
        <span v-else>
        <input type="text" v-model="attachment_one"/>
        </span>
        <p></p>
        <span>2)</span>
        <span v-if="lock_inputs">@{{attachment_two}}</span>
        <span v-else>
        <input type="text" v-model="attachment_two"/>
        </span>
    </div>
    <div v-if="selected_code_id==8" class="content">
        <p><br></p>
        <p style="font-size: 18px; text-align: center"><strong
            >Согласие на постоянную прописку</strong>
        </p>
        <p style="font-size: 18px; text-align: center"><strong
            >Заявление</strong>
        </p>
        <p>
            <span>Прошу Вас дать согласие на регистрацию меня в Департаменте &quot;Центр обслуживания населения - филиала НАО &quot;Государственная корпорация &quot;Правительство для граждан&quot; по адресу: {{$data['JK']}}</span>
        </p>
        <p><span>{{$data['FIO']??""}}</span>
        </p>
        <p><strong>и членов моей семьи</strong></p>
        <span>1)</span>
        <span v-if="lock_inputs">@{{attachment_one}}</span>
        <span v-else>
            <input placeholder="(Ф.И.О., и степень родства)" type="text" v-model="attachment_one"/>
        </span>
        <p></p>
        <span>2)</span>
        <span v-if="lock_inputs">@{{attachment_two}}</span>
        <span v-else>
            <input placeholder="(Ф.И.О., и степень родства)" type="text" v-model="attachment_two"/>
        </span>
        <p><span>на постоянное место жительство по адресу: </span><span>{{$data['JK']??""}}&nbsp;</span>
        <p><br>
        </p>
    </div>
    <div v-if="selected_code_id==9" class="content">
        <p><br></p>
        <p style="font-size: 18px; text-align: center"><strong>Расторжение договора</strong></p>
        <p>&nbsp;</p>
        <p style="font-size: 18px; text-align: center"><strong>ЗАЯВЛЕНИЕ</strong></p>
        <p>&nbsp;</p>
        <p class="appeal-text">
        В связи с
        <span v-if="lock_inputs">@{{reason}}</span>
        <span v-else>
            <input placeholder="причина" type="text" v-model="reason"/>
        </span>
        <span>прошу Вас расторгнуть Договор аренды с выкупом жилого помещения от {{$data['date_d']??""}} года
            №{{$id??""}} авто (далее &ndash; Договор) согласно утвержденной процедуре.</span>
        </p>
        <p><br></p>
        <p><br>
        </p>
        <p>&nbsp;</p>
    </div>
    <div v-if="selected_code_id==10" class="content">
        <div style="margin-bottom: 25px; text-align: center">
        <input placeholder="Тема" v-model="appeal_title">
        </div>
        <textarea style="width: 100%" v-model="appeal_text"></textarea>
    </div>
    @include('appeals_pdf_templates.appeal_footer')
</div>
</div>
