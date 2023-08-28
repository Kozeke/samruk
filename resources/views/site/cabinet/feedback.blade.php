@extends('site.cabinet.base_show')

@push('js')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
    <script src="/site/js/appeals.js"></script>

@endpush
@section('show_cabinet')
    <div id="feedback">
        @include('appeals_pdf_templates.appeals-history')
        <div style="margin-top: 5%; text-align: left">
            <h2 class="title-page">Оставить обращение</h2>
        </div>
        <form class="form-panel" action="{{ url('/cabinet/'.$id.'/feedback_template') }}" method="get">
            {!! csrf_field(); !!}

            <div class="row row--sm">
                @if ($vid['data']['result'] == 1)
                    <div class="col-12">
                        <div class="alert alert--danger">
                            Ошибка сервера: <b>{{ $vid['data']['comment'] }}</b>
                        </div>
                    </div>
                @else
                    @if (session()->has('error'))
                        <div class="col-12">
                            <div class="alert alert--danger">
                                {{ session('error') }}
                            </div>
                        </div>
                    @else
                        @if (session()->has('success'))
                            <div class="col-12">
                                <div class="alert alert--success mb-0">
                                    Ваше обращение зарегистрировано под номером <b>{{ session('success') }}</b>
                                </div>
                            </div>
                        @else
                            <div v-if="successMessage" class="col-12">
                                <div class="alert alert--success mb-0">
                                    Ваше обращение зарегистрировано под номером <b>{{ session('success') }}</b>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group {{ $errors->has('theme') ? 'has-error' : '' }}">
                                    <div class="form-group__label">Тема обращения</div>
                                    <div class="form-group__input">
                                        <div class="select">
                                            <select v-model="selected_code_id" name="chosen_code_id">
                                                @foreach($vid['data']['vid_docs']['vid'] as $type)
                                                    <option value="{{ $type['kod'] }}">{{ $type['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @if ($errors->has('type_doc'))
                                        <div class="form-group__error">{!! $errors->first('type_doc') !!}</div>
                                    @endif
                                </div>
                            </div>

                            {{--                        <div class="col-12">--}}
                            {{--                            <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">--}}
                            {{--                                <div class="form-group__label">Шаблон</div>--}}


                            {{--                            </div>--}}
                            {{--                        </div>--}}

                            <div class="col-12">
                                <div class="form-panel__actions">
{{--                                    {{ Form::submit(trans('translations.gb.send'), ['class' => 'btn btn--secondary']) }}--}}
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
            @include('appeals_pdf_templates.appeals_content')
        </form>
    </div>
@endsection
