@extends('site.templates.pages')

@push('js')
    <script src="/site/js/calculator.js"></script>
@endpush

@section('intro-page')
    @include('site.blocks.sections.intro-page')
@endsection

@section('content')
    @component('site.component.page')

        {!! csrf_field() !!}

        <div class="calculator" id="calculator">
            <input type="hidden" id="lang" name="lang" value="{{App::getLocale()}}">
            <div class="calculator__form mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-field">
                            <label class="form-field__label">{{trans('translations.calculator.name')}}</label>

                            <div class="form-field__input">
                                <input class="input" type="text">
                            </div>
                        </div><!-- /.form-field -->
                    </div>

                    <div class="col-md-6">
                        <div class="form-field">
                            <label class="form-field__label">{{trans('translations.calculator.complex')}}</label>

                            <div class="form-field__input">
                                <div class="select">
                                    <select v-model="complex" v-on:change="getApartments" id="complexes">
                                        @foreach($complexes as $complexe)
                                            @php $title = 'title_'. App::getLocale(); @endphp
                                            <option value="{{ $complexe->id }}" @if ($loop->index == 0) selected @endif>{{ $complexe->$title }}</option>
                                        @endforeach
                                    </select>
                                </div><!-- /.select -->
                            </div>
                        </div><!-- /.form-field -->
                    </div>

                    <div class="col-md-12">
                        <div class="form-field">
                            <label class="form-field__label">{{trans('translations.calculator.type')}}</label>

                            <div class="form-field__input">
                                <div class="select">
                                    <select v-model="apartment_id" v-on:change="getApartmentCost">
                                        <option v-for="apartment in apartments" :value="apartment.id" >@[[apartment.title]]@</option>
                                    </select>
                                </div><!-- /.select -->

                                <div class="mt-3">
                                    {{trans('translations.calculator.cost')}}
                                    <span class="font-weight-600" v-model="cost">@[[ cost ]]@ тг</span>
                                </div>
                            </div>
                        </div><!-- /.form-field -->
                    </div>

                    <div class="col-md-12">
                        <div class="form-field">
                            <label class="form-field__label">{{trans('translations.calculator.first_pay')}}</label>

                            <div class="form-field__input">
                                <input class="input" type="text" v-model="initial_fee">
                            </div>
                        </div><!-- /.form-field -->
                    </div>

                    <div class="col-md-12">
                        <div class="form-field">
                            <label class="form-field__label">{{trans('translations.calculator.arenda_srok')}}</label>

                            <div class="form-field__input">
                                <div class="select">
                                    @if (App::getLocale() == 'ru')
                                        @php $terms_of_contract = ['5 лет' => 5, '7 лет' => 7, '10 лет' => 10, '13 лет' => 13] @endphp
                                    @elseif (App::getLocale() == 'kz')
                                        @php $terms_of_contract = ['5 жыл' => 5, '7 жыл' => 7, '10 жыл' => 10, '13 жыл' => 13] @endphp
                                    @else
                                        @php $terms_of_contract = ['5 лет' => 5, '7 лет' => 7, '10 лет' => 10, '13 лет' => 13] @endphp
                                    @endif

                                    <select v-model="tenancy">
                                        @foreach ($terms_of_contract as $label => $term)
                                            <option value="{{ $term }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div><!-- /.select -->
                            </div>
                        </div><!-- /.form-field -->
                    </div>

                    <div class="col-md-12">
                        <div class="form-field">
                            <label class="form-field__label">
                                {{trans('translations.calculator.family')}}
                            </label>

                            <div class="form-field__input">
                                <div class="select">
                                    <select v-model="family">
                                        @for ($person = 0; $person < 10; $person++)
                                            <option value="{{ $person }}">{{ $person }}</option>
                                        @endfor
                                    </select>
                                </div><!-- /.select -->
                            </div>
                        </div><!-- /.form-field -->
                    </div>

                    <div class="col-md-12">
                        <div class="form-field">
                            <label class="form-field__label">
                                {{trans('translations.calculator.co_aplicant')}}
                            </label>

                            <div class="form-field__input">
                                <div class="select">
                                    <select v-model="co_applicants" v-on:change="changeApplicants">
                                        @for ($co_applicant = 0; $co_applicant < 3; $co_applicant++)
                                            <option value="{{ $co_applicant }}">{{ $co_applicant }}</option>
                                        @endfor
                                    </select>
                                </div><!-- /.select -->
                            </div>
                        </div><!-- /.form-field -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="font-weight-600 mb-4">{{trans('translations.calculator.income')}}</div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-field">
                            <label class="form-field__label">{{trans('translations.calculator.income_first')}}</label>

                            <div class="form-field__input">
                                <input class="input" type="text" v-model="income[0]" required>
                            </div>
                        </div><!-- /.form-field -->
                    </div>

                    <div class="col-md-12">
                        <div class="form-field">
                            <label class="form-field__label">{{trans('translations.calculator.income_dop')}}</label>

                            <div class="form-field__input">
                                <input class="input" type="text" v-model="additional[0]">
                            </div>
                        </div><!-- /.form-field -->
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3" v-if="co_applicants > 0" v-for="(item, index) in parseInt(co_applicants)">
                            <div class="form-field">
                                <label class="form-field__label">{{trans('translations.calculator.income_first')}} * @[[ index + 1 ]]@</label>

                                <div class="form-field__input">
                                    <input class="input" type="text" v-model="income[index + 1]">
                                </div>
                            </div><!-- /.form-field -->

                            <div class="form-field">
                                <label class="form-field__label">{{trans('translations.calculator.income_dop')}}  @[[ index + 1 ]]@</label>

                                <div class="form-field__input">
                                    <input class="input" type="text" v-model="additional[index + 1]">
                                </div>
                            </div><!-- /.form-field -->

                            <hr>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-field">
                            <div class="form-check">
                                <label class="form-check__label">
                                    <input type="checkbox" v-model="obligation" v-on:change="payment = []">
                                    <span>{{trans('translations.calculator.payment')}}</span>
                                </label>
                            </div><!-- /.form-check -->
                        </div><!-- /.form-field -->
                    </div>

                    <div class="col-md-12">
                        <div class="form-field" v-if="obligation">
                            <label class="form-field__label">{{trans('translations.calculator.obligation_credit')}}</label>

                            <div class="form-field__input">
                                <input class="input" type="text" v-model="payment[0]">
                            </div>
                        </div><!-- /.form-field -->

                        <div class="form-field" v-if="obligation">
                            <label class="form-field__label">
                                {{trans('translations.calculator.obligation_nalog')}}
                            </label>

                            <div class="form-field__input">
                                <input class="input" type="text" v-model="payment[1]">
                            </div>
                        </div><!-- /.form-field -->

                        <div class="form-field" v-if="obligation">
                            <label class="form-field__label">
                                {{trans('translations.calculator.obligation_sum')}}
                            </label>

                            <div class="form-field__input">
                                <input class="input" type="text" v-model="payment[2]">
                            </div>
                        </div><!-- /.form-field -->

                        <div class="form-field" v-if="obligation">
                            <label class="form-field__label">
                                {{trans('translations.calculator.obligation_strax')}}
                            </label>

                            <div class="form-field__input">
                                <input class="input" type="text" v-model="payment[3]">
                            </div>
                        </div><!-- /.form-field -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-field">
                            <div class="form-check">
                                <label class="form-check__label">
                                    <input type="checkbox" v-model="confirmation">
                                    <span>
									{{trans('translations.calculator.confirmation')}}
								</span>
                                </label>
                            </div><!-- /.form-check -->
                        </div><!-- /.form-field -->
                    </div>
                </div>
            </div>

            <div class="calculator__info formatted-body">
                {!!trans('translations.calculator.star')!!}
                <p>{{trans('translations.calculator.rasschet')}}</p>
            </div>

            <div class="calculator__actions text-center">
                <button class="btn" id="print_result">{{trans('translations.calculator.print_result')}}</button>

                <button class="btn" v-on:click="calculate" v-bind:disabled="!confirmation">{{trans('translations.calculator.calculate')}}</button>

                <button class="btn" id="clear" v-on:click="clearData">{{trans('translations.calculator.clear')}}</button>
            </div>

            <div class="calculator__result" v-if="result.rent_payment">
                <div class="formatted-body mb-4">
                    <ul>
                        <li>Размер ежемесячного арендного платежа: <b>@[[ result.rent_payment ]]@</b></li>
                        <li>Сумма гарантийного взноса необходимого для заключения договора аренды с выкупом: <b>@[[ result.margin ]]@</b></li>
                        <li>Расчет МСАП: <b>@[[ result.msap ]]@</b></li>
                    </ul>
                </div>

                <div class="formatted-body mb-4" v-if="result.message">
                    Ваш МСАП достаточен
                </div>

                <div class="formatted-body mb-4" v-else>
                    Ваш МСАП недостаточен
                </div>

                <div class="form-field">
                    <label class="form-field__label">E-mail</label>

                    <div class="form-field__input">
                        <input class="input" type="text">
                    </div>
                </div><!-- /.form-field -->

                <button class="btn">Отправить результат на e-mail</button>
            </div>
        </div>

    @endcomponent
@endsection
