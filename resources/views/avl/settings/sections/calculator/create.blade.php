@extends('avl.default')

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
  <link rel="stylesheet" href="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.css">
@endsection

@section('main')
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> Создание
        <div class="card-actions">
          <a href="{{ url('/admin/settings/sections/'.$section->id.'/calculator') }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ url('/admin/settings/sections/'.$section->id.'/calculator/') }}" method="post" id="submit">
          {!! csrf_field(); !!}

                <div class="row">
									@foreach($langs as $lang)
	                  <div class="col-4">
	                    <div class="form-group">
	                      <label>Наименование ЖК [{{ $lang->key }}}]</label>
	                      <input type="text" class="form-control" name="complexe_title_{{ $lang->key }}" value="">
	                    </div>
	                  </div>
									@endforeach
                </div>

								<div class="row">
									<div class="col-3">
										<div class="form-group">
                      <label>Арендный платеж на 1 м2 : <b>[5 лет]</b></label>
                      <input type="text" class="form-control" name="complexe_rent_5" value="">
                    </div>
									</div>
									<div class="col-3">
										<div class="form-group">
                      <label>Арендный платеж на 1 м2 : <b>[7 лет]</b></label>
                      <input type="text" class="form-control" name="complexe_rent_7" value="">
                    </div>
									</div>
									<div class="col-3">
										<div class="form-group">
                      <label>Арендный платеж на 1 м2 : <b>[10 лет]</b></label>
                      <input type="text" class="form-control" name="complexe_rent_10" value="">
                    </div>
									</div>
									<div class="col-3">
										<div class="form-group">
                      <label>Арендный платеж на 1 м2 : <b>[15 лет]</b></label>
                      <input type="text" class="form-control" name="complexe_rent_15" value="">
                    </div>
									</div>
								</div>

								<div class="row">
									<div class="col-6">
										<div class="form-group">
                      <label>Себестоимость 1 м2</label>
                      <input type="text" class="form-control" name="complexe_cost" value="">
                    </div>
									</div>
									<div class="col-6">
										<div class="form-group">
                      <label>Стоимость продажи 1 м2</label>
                      <input type="text" class="form-control" name="complexe_purchase" value="">
                    </div>
									</div>
								</div>

          </div></br>
        </form>
      </div>
    </div>
@endsection

@section('js')
  <script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
  <script src="/avl/js/uploadifive/jquery.uploadifive.min.js" charset="utf-8"></script>

  <script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>

  <script src="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.js" charset="utf-8"></script>
@endsection
