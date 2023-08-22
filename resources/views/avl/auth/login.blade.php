<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="IRsite - Панель управления">
  <meta name="author" content="IR.KZ - anatoliy@ir.kz">
  <meta name="keyword" content="">
  <link rel="shortcut icon" href="img/favicon.png">
  <title>IRsite - Панель управления</title>

  <!-- Icons -->
  <link href="/avl/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="/avl/css/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

  <!-- Main styles for this application -->
  <link href="/avl/css/style.css" rel="stylesheet">
  <!-- Styles required by this views -->

</head>

<body class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">

              <div class="card-body">

                  <form action="" method="post">
                      {{ csrf_field() }}
                    <h1>Вход</h1>
                    <p class="text-muted">Войдите под своим логином</p>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="icon-user"></i></span>
                      </div>
                      <input type="text" name="email" class="form-control @if ($errors->has('email')) is-invalid @endif" placeholder="E-mail" value="{{ old('email') }}">
                      @if ($errors->has('email'))<div class="invalid-feedback">{{ $errors->first('email') }}</div>@endif
                    </div>
                    <div class="input-group mb-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="icon-lock"></i></span>
                      </div>
                      <input type="password" name="password" class="form-control @if ($errors->has('password') || $errors->has('field')) is-invalid @endif" placeholder="Пароль">
                      @if ($errors->has('password') || $errors->has('field'))
                        @if ($errors->has('password'))<div class="invalid-feedback">{{ $errors->first('password') }}</div>@endif
                        @if ($errors->has('field'))<div class="invalid-feedback">{{ $errors->first('field') }}</div>@endif
                      @endif
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <button type="submit" class="btn btn-primary px-4">Войти</button>
                      </div>
                      {{-- <div class="col-6 text-right">
                        <button type="button" class="btn btn-link px-0">Напомнить пароль</button>
                      </div> --}}
                    </div>
                </form>
              </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none position-relative" style="width:44%">
              <div class="card-img-top"><img class="m-auto d-block" src="/avl/img/ir-logo.png"></div>
              <div class="card-body text-center mb-3">
                <div>
                  <h2>CMS IRsite v3.1</h2>
                  <h5 style="font-size: 15px;">Служба поддержки клиентов - <a href="http://support.ir.kz" target="_blank" class="text-white">support.ir.kz</a></h5>
                  {{-- <p>г. Астана, ул. Куйши Дина 23/1, оф. 4, 5</p> --}}
                  <div class="row mt-3">
                    <div class="col-md-4 text-right"><b>Телефон:</b></div>
                    <div class="col-md-8 text-left">+7 (7172) 47-85-31 <br/>+7 (7172) 47-85-32 <br/>+7 (7172) 36-78-77 <br/>+7 (7172) 35-91-84</div>
                  </div>
                </div>
              </div>

              <div class="card-footer position-absolute fixed-bottom" style="background: none; border-color: #c2cfd6;">
                &copy; Copyright {{ date('Y') }}, ТОО "IR.KZ" <br/>
                <small class="text-muted" style="font-size: 11px;">Свидетельство ИС 04145, № 205 от 09 марта 2010 года</small>
              </div>

            </div>


          </div>
        </div>
      </div>
    </div>
</body>
</html>
