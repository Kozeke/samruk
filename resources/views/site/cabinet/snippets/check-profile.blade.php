<!-- The Modal -->
<div id="checkProfileNeed" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <span style="text-align: center">
        <h1>Вам нужно подтвердить актуальность ваших данных</h1>
            <hr class="form-auth__separator">
            <form class="form-auth form-panel"
                  action="{{ route('cabinet.check-profile-relevance')}}" method="post">
            {!! csrf_field() !!}
                <div class="row row--sm">
                    <div class="col-12 col-xl-4">
                        <label class="form-group__label">Номер телефона</label>
                        <div class="form-group">
                            <div class="form-group__input">
                                <input class="input" type="text" name="mobile" value="{{$user['mobile']}}"
                                       data-input-phone>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="form-group">
                            <label class="form-group__label">E-mail</label>
                                <div class="form-group__input">
                                    <input class="input" type="email" name="email" value="{{$user['email']}}">
                                </div>
                            </div>
                        </div>
                    <div class="col-12 col-xl-4">
                        <div class="form-group">
                            <label class="form-group__label">Адрес проживания</label>

                            <div class="form-group__input">
                                <input class="input" type="text" name="address" value="{{$user['address']}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="form-group">
                            <label class="form-group__label">Рабочий телефон</label>

                            <div class="form-group__input">
                                <input class="input" type="text" name="work_phone" value="{{$user['work_phone']}}"
                                       data-input-phone>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="form-group">
                            <label class="form-group__label">Домашний телефон</label>

                            <div class="form-group__input">
                                <input class="input" type="text" name="home_phone" value="{{$user['homephone']}}"
                                       data-input-phone>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn--secondary" type="submit">Сохранить</button>

            </form>


    </span>
    </div>

</div>
