<div v-if="selected_code_id"
     style="{{$editing!==2?"border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">
    @include('appeals_pdf_templates.appeal_header')
    <div style="font-size: 14px;" v-if="selected_code_id==1">
        <p><br></p>
        <p style="text-align: center;font-size: 14px"><strong>Частично досрочное погашение</strong></p>
        <p style="text-align: center;"><strong>&nbsp;</strong></p>
        <p style="text-align: center;font-size: 14px"><strong>ЗАЯВЛЕНИЕ</strong></p>
        <p>&nbsp;</p>
        <p style="font-size: 14px">Настоящим прошу Вас разрешить внести на частично досрочное погашение сумму в
            размере
            <span v-if="lock_inputs">
                        @{{partial_early_repayment_of_the_amount}}
                    </span>
            <span v-if="!lock_inputs">
                     <input v-model="partial_early_repayment_of_the_amount" type="number"/>
                </span>
            тенге
            по Договору аренды с выкупом жилого помещения от {{$data['date_d']??""}} года &nbsp;№{{$id??""}}
            ,
            на
            <span v-if="lock_inputs">
                        @{{date_to_finish}}
                    </span>
            <span v-if="!lock_inputs">
                    <input v-model="date_to_finish"
                           type="date"
                    />
                </span>

    </div>
    <div v-if="selected_code_id==2">
        <div style="font-size: 14px">
            <p><br></p>
            <p style=" text-align: center;font-size: 14px"><strong>Полный досрочный выкуп</strong></p>
            <p>&nbsp;</p>
            <p style="font-size: 14px;text-align: center;">
                <strong><u>ЗАЯВЛЕНИЕ</u></strong></p>
            <p>&nbsp;</p>
            Прошу Вас разрешить произвести полный досрочный выкуп арендуемого мною жилого помещения, расположенного
            по
            адресу: {{$data['JK']??""}}
            согласно условий Договора аренды с выкупом жилого помещения от
            {{$data['date_d']??""}} года № {{$id??""}} (далее &ndash; Договор), по
            состоянию на
            <span v-if="lock_inputs">
                @{{values['date_to_finish']}}
            </span> года.
            <span v-if="lock_inputs">
                <input type="date" v-model="date_to_finish"/>
            </span>
            &nbsp;
            <p><br></p>

        </div>
        <div v-if="selected_code_id==3">

        </div>
        <p><br></p>
        <div style="position: absolute; top: 19.5%;left: 95px">

            <div v-if="!lock_inputs" style="position: absolute">
                <button type="button" href="#" class="btn btn--secondary" v-on:click="lockInputs">Посмотреть
                </button>
            </div>
            <div v-else style="position: absolute">
                <button type="button" href="#" class="btn btn--secondary" v-on:click="lockInputs">
                    Отредактировать
                </button>
            </div>
        </div>
        <div style="position: absolute; left: 400px; top: 19.5%;">
            <button type="button" href="#" class="btn btn--secondary" v-on:click="printPdf">Печать
            </button>

        </div>
    </div>
@include('appeals_pdf_templates.appeal_footer')

