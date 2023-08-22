@extends('avl.default')

@section('js')
	<script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
	<script src="/avl/js/uploadifive/jquery.uploadifive.min.js" charset="utf-8"></script>

	<script src="/avl/js/modules/settings/objects/edit.js" charset="utf-8"></script>
	<script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>

	<script src="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.js" charset="utf-8"></script>
@endsection

@section('css')
	<link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
	<link rel="stylesheet" href="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.css">
@endsection

@section('main')
	<div class="card">
		<div class="card-header">
				<i class="fa fa-align-justify"></i> Добавить объект
				<div class="card-actions">
					<a href="{{ route('admin.settings.sections.objects.index', [ 'id' => $section->id ]) }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
					<button type="submit" form="submit" name="button" value="add" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить и добавить новую"><i class="fa fa-plus"></i></button>
					<button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить и перейти к списку"><i class="fa fa-floppy-o"></i></button>
					<button type="submit" form="submit" name="button" value="edit" class="btn btn-warning pl-3 pr-3" style="width: 70px;" title="Сохранить и изменить"><i class="fa fa-floppy-o"></i></button>
				</div>
		</div>
		<div class="card-body">
			<form action="{{ route('admin.settings.sections.objects.store', [ 'id' => $section->id ]) }}" method="post" id="submit">
				{!! csrf_field(); !!}

				<div class="row">
					<div class="col-6 col-md-3">
						<div class="form-group">
							{{ Form::label(null, 'Дата публикации') }}
							{{ Form::text('published_at', date('Y-m-d'), ['id' => 'datepicker', 'class' => 'form-control']) }}
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="form-group">
							{{ Form::label(null, 'Время публикации') }}
							{{ Form::text('published_time', date('H:i'), ['class' => 'form-control timepicker']) }}
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="form-group">
							{{ Form::label(null, 'Программа') }}
							{{ Form::select('program', trans('objects.programs', [], 'ru'), null, ['placeholder' => 'Выберите программу', 'class' => 'form-control']) }}
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="form-group">
							{{ Form::label(null, 'Тип объекта') }}
							{{ Form::select('type', trans('objects.types', [], 'ru'), null, ['placeholder' => 'Выберите тип объекта', 'class' => 'form-control']) }}
						</div>
					</div>
					@if ($section->rubric == true)
						<div class="col-12">
							<div class="form-group">
								{{ Form::label(null, 'Рубрика') }}
								{{ Form::select('rubric_id', $rubrics, null, ['placeholder' => 'Выберите рубрику', 'class' => 'form-control']) }}
							</div>
						</div>
					@endif
				</div>

				<ul class="nav nav-tabs" role="tablist">
					@foreach($langs as $lang)
						<li class="nav-item"><a class="nav-link @if($lang->key == 'ru') active show @endif" href="#title_{{ $lang->key }}" data-toggle="tab">{{ $lang->name }}</a></li>
					@endforeach
				</ul>
				<div class="tab-content">
					@foreach ($langs as $lang)

						<div class="tab-pane @if($lang->key == "ru") active show @endif"  id="title_{{$lang->key}}" role="tabpanel">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item"><a class="nav-link active show" href="#sub-tab_{{ $lang->key }}-about" data-toggle="tab">О комплексе</a></li>
								<li class="nav-item"><a class="nav-link" href="#sub-tab_{{ $lang->key }}-infrastructure" data-toggle="tab">Инфраструктура</a></li>
								<li class="nav-item"><a class="nav-link" href="#sub-tab_{{ $lang->key }}-plans" data-toggle="tab">Планировки</a></li>
								<li class="nav-item"><a class="nav-link" href="#sub-tab_{{ $lang->key }}-circs" data-toggle="tab">Условия</a></li>
								<li class="nav-item"><a class="nav-link" href="#sub-tab_{{ $lang->key }}-developer" data-toggle="tab">O застройщике</a></li>
								<li class="nav-item"><a class="nav-link" href="#sub-tab_{{ $lang->key }}-location" data-toggle="tab">Месторасположение</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active show"  id="sub-tab_{{ $lang->key }}-about" role="tabpanel">
									<div class="row">
										<div class="col-3 col-sm-1">
											<div class="form-group">
												{{ Form::label('Вкл / Выкл') }}<br/>
												<label class="switch switch-3d switch-primary">
													{{ Form::checkbox('good_' . $lang->key, 1, null, ['class' => 'switch-input']) }}
													<span class="switch-label"></span>
													<span class="switch-handle"></span>
												</label>
											</div>
										</div>
										<div class="col-9 col-sm-11">
											<div class="form-group">
												{{ Form::label('Название') }}
												{{ Form::text('title_' . $lang->key, null, ['class' => 'form-control']) }}
											</div>
										</div>
										<div class="col-12">
											{{ Form::textarea('about_' . $lang->key, null, ['class' => 'tinymce']) }}
										</div>
									</div>
								</div>

								<div class="tab-pane"  id="sub-tab_{{ $lang->key }}-infrastructure" role="tabpanel">
									{{ Form::textarea('infrastructure_' . $lang->key, null, ['class' => 'tinymce']) }}
								</div>

								<div class="tab-pane"  id="sub-tab_{{ $lang->key }}-plans" role="tabpanel">
									{{ Form::textarea('plans_' . $lang->key, null, ['class' => 'tinymce']) }}
								</div>

								<div class="tab-pane"  id="sub-tab_{{ $lang->key }}-circs" role="tabpanel">
									{{ Form::textarea('circs_' . $lang->key, null, ['class' => 'tinymce']) }}
								</div>

								<div class="tab-pane"  id="sub-tab_{{ $lang->key }}-developer" role="tabpanel">
									{{ Form::textarea('developer_' . $lang->key, null, ['class' => 'tinymce']) }}
								</div>

								<div class="tab-pane"  id="sub-tab_{{ $lang->key }}-location" role="tabpanel">
									{{ Form::textarea('location_' . $lang->key, null, ['class' => 'tinymce']) }}
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</form>
		</div>
		<div class="card-footer position-relative">
				<i class="fa fa-align-justify"></i> Добавление новости
				<div class="card-actions">
					<a href="{{ route('admin.settings.sections.objects.index', [ 'id' => $section->id ]) }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
					<button type="submit" form="submit" name="button" value="add" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить и добавить новую"><i class="fa fa-plus"></i></button>
					<button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить и перейти к списку"><i class="fa fa-floppy-o"></i></button>
					<button type="submit" form="submit" name="button" value="edit" class="btn btn-warning pl-3 pr-3" style="width: 70px;" title="Сохранить и изменить"><i class="fa fa-floppy-o"></i></button>
				</div>
		</div>
	</div>
@endsection
