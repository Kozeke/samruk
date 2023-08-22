<div v-if="selected_code_id"
     style="{{$editing!==2?"border: 1px solid black; margin:3%; padding: 2%; border-radius: 2px; background-color: whitesmoke":""}}">
    @include('appeals_pdf_templates.appeal_header')
    <div style="font-size: 14px;" v-if="selected_code_id==1">
        <p><br></p>
        <p style="text-align: center;font-size: 14px"><strong>Частично досрочное погашение</strong></p>
        <p style="text-align: center;"><strong>&nbsp;</strong></p>
        <p style="text-align: center;font-size: 14px"><strong>ЗАЯВЛЕНИЕ</strong></p>
        <p>&nbsp;</p>
        @if($editing !== 2)
            <form action="{{ url('/cabinet/'.$id.'/feedback_template/view') }}" method="post">
                {!! csrf_field() !!}
                @endif
                <p style="font-size: 14px">Настоящим прошу Вас разрешить внести на частично досрочное погашение сумму в
                    размере
                    <span v-if="lock_inputs">
                        @{{partial_early_repayment_of_the_amount}}
                    </span>
                    <span v-if="!lock_inputs">
                     <input v-model="partial_early_repayment_of_the_amount" type="number"/>
                </span>
                    <input type="hidden" name="chosen_code_id" value="{{$chosen_code_id??""}}"/>
                    <input type="hidden" name="editing" value="{{$editing??0}}"/>
                    <input type="hidden" name="date_from"
                           value="{{$values['date_from']??""}}"/>
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

            </form>
            <div style="position: absolute; left: 400px; top: 19.5%;">
                <button type="button" href="#" class="btn btn--secondary" v-on:click="printPdf">Печать
                </button>

            </div>
    </div>
    <div v-if="selected_code_id==2">
        <div style="font-size: 14px">
            <p><br></p>
            <p style=" text-align: center;font-size: 14px"><strong>Полный досрочный выкуп</strong></p>
            <p>&nbsp;</p>
            <p style="font-size: 14px;text-align: center;">
                <strong><u>ЗАЯВЛЕНИЕ</u></strong></p>
            <p>&nbsp;</p>
            <form action="{{ url('/cabinet/'.$id.'/feedback_template/view') }}" method="post">
                {!! csrf_field() !!}
                Прошу Вас разрешить произвести полный досрочный выкуп арендуемого мною жилого помещения, расположенного
                по
                адресу: {{$data['JK']??""}}
                согласно условий Договора аренды с выкупом жилого помещения от
                {{$data['date_d']??""}} года № {{$id??""}} (далее &ndash; Договор), по
                состоянию на
                @if($editing)
                    {{$values['date_from']}} года.
                @endif


                <input type="{{$editing?"hidden":"date"}}" name="date_from"
                       value="{{$values['date_from']??""}}"/>
                &nbsp;
                <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>
                <input type="hidden" name="editing" value="{{$editing??0}}"/>
                <p><br></p>
                @if($editing !== 2)
                    <div style="position: absolute; top: 8px;left: 550px">
                        <div style="position: absolute; top: 53.5%;left: 100px">
                            @if($editing === 0)
                                <div style="position: absolute">
                                    {{ Form::submit(trans('translations.gb.view'), ['class' => 'btn btn--secondary']) }}
                                </div>
                            @endif
                            @if($editing === 1)
                                <div style="position: absolute">
                                    {{ Form::submit(trans('translations.gb.edit'), ['class' => 'btn btn--secondary']) }}
                                </div>
                            @endif
                        </div>
            </form>
            <div style="position: absolute; top:-13px; left: 155px">
                <form action="{{ url('/cabinet/'.$id.'/feedback_template/print') }}" method="post">`
                    {!! csrf_field() !!}

                    <input type="hidden" name="appeal_chosen_view" value="{{$appeal_chosen_view??""}}"/>
                    <input type="hidden" name="date_from"
                           value="{{$values['date_from']??""}}"/>

                    {{ Form::submit(trans('translations.gb.print'), ['class' => 'btn btn--secondary']) }}

                </form>
                @endif
            </div>
        </div>

    </div>
    <div v-if="selected_code_id==3">

    </div>
    <p><br></p>

</div>
@include('appeals_pdf_templates.appeal_footer')

