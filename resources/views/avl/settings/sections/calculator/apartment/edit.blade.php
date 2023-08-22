@extends('avl.default')

@section('css')
  <link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
  <link rel="stylesheet" href="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.css">
@endsection

@section('main')
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i>  Редактирование : <b>[{{ $apartment->name_ru }}]</b>
        <div class="card-actions">
          <a href="{{ url('/admin/settings/sections/'.$section->id.'/calculator/'.$complex->id.'/apartment') }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
          <button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ url('/admin/settings/sections/'.$section->id.'/calculator/'.$complex->id.'/apartment/'.$apartment->id) }}" method="post" id="submit">
          {!! csrf_field(); !!}
					{{ method_field('PUT') }}

                <div class="row">
									@foreach($langs as $lang)
											@php $name = 'name_' . $lang->key; @endphp
										<div class="col-3">
											<div class="form-group">
												<label>Тип жилого помещения [{{ $lang->key }}}]</label>
												<input type="text" class="form-control" name="apartment_name_{{ $lang->key }}" value="@if(old('apartment_name_'.$lang->key)){{ old('apartment_name_'.$lang->key) }}@else{{ $apartment->$name }}@endif">
												</div>
											</div>
									@endforeach
                  <div class="col-3">
                    <div class="form-group">
                      <label>Квадратура</label>
                      <input type="text" class="form-control" name="apartment_measure" value="@if(old('apartment_measure')){{ old('apartment_measure') }}@else{{ $apartment->measure }}@endif">
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

  <script src="/avl/js/modules/settings/links/edit.js" charset="utf-8"></script>
  <script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>

  <script src="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.js" charset="utf-8"></script>
@endsection
