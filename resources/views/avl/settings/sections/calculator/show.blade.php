@extends('avl.default')

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
  <link rel="stylesheet" href="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.css">
@endsection

@section('main')
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> Просмотр <b>[{{ $complex->title_ru }}]</b>
				<div class="card-actions">
          <a href="{{ url('/admin/settings/sections/'.$id.'/calculator') }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
        </div>
      </div>
      <div class="card-body">

            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label>Наименование ЖК</label>
                  <span type="text" class="form-control" name="complexe_title_ru" value="">{{ $complex->title_ru }}</span>
                </div>
              </div>
            </div>

						<div class="row">
							<div class="col-3">
								<div class="form-group">
                  <label>Арендный платеж на 1 м2 : <b>[5 лет]</b></label>
                  <span type="text" class="form-control" name="complexe_rent_5" value="">{{ $complex->rent_5 }}</span>
                </div>
							</div>
							<div class="col-3">
								<div class="form-group">
                  <label>Арендный платеж на 1 м2 : <b>[7 лет]</b></label>
                  <span type="text" class="form-control" name="complexe_rent_7" value="">{{ $complex->rent_7 }}</span>
                </div>
							</div>
							<div class="col-3">
								<div class="form-group">
                  <label>Арендный платеж на 1 м2 : <b>[10 лет]</b></label>
                  <span type="text" class="form-control" name="complexe_rent_10" value="">{{ $complex->rent_10 }}</span>
                </div>
							</div>
							<div class="col-3">
								<div class="form-group">
                  <label>Арендный платеж на 1 м2 : <b>[15 лет]</b></label>
                  <span type="text" class="form-control" name="complexe_rent_15" value="">{{ $complex->rent_15 }}</span>
                </div>
							</div>
						</div>

						<div class="row">
							<div class="col-6">
								<div class="form-group">
                  <label>Себестоимость 1 м2</label>
                  <span type="text" class="form-control" name="complexe_cost" value="">{{ $complex->cost }}</span>
                </div>
							</div>
							<div class="col-6">
								<div class="form-group">
                  <label>Стоимость продажи 1 м2</label>
                  <span type="text" class="form-control" name="complexe_purchase" value="">{{ $complex->purchase }}</span>
                </div>
							</div>
						</div>

        </div></br>
      </div>
    </div>
@endsection

@section('js')
  <script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
  <script src="/avl/js/uploadifive/jquery.uploadifive.min.js" charset="utf-8"></script>

  <script src="/avl/js/modules/settings/links/edit.js" charset="utf-8"></script>
  <script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>

  <script src="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.js" charset="utf-8"></script>
@endsection
