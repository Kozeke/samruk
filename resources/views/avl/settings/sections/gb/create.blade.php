@extends('avl.default')

@section('css')
	<link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.css">
@endsection


@section('main')
		<div class="card">
			<div class="card-header">
					<i class="fa fa-align-justify"></i> Добавить вопрос
					<div class="card-actions">
						<button type="submit" form="submit" name="button" value="save" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
					</div>
			</div>
			<div class="card-body">
				<form action="{{ route('admin.settings.sections.gb.store', ['id' => $section->id]) }}" method="post" id="submit">
					{!! csrf_field(); !!}

					<div class="row">
						<div class="col-12 col-sm-2 col-md-1">
							<div class="form-group">
								{{ Form::label(null, 'Вкл / Выкл') }} <br/>
								<label class="switch switch-3d switch-primary">
									{{ Form::hidden('good', 0, ) }}
									{{ Form::checkbox('good', 1, null, ['class' => 'switch-input']) }}
									<span class="switch-label"></span>
									<span class="switch-handle"></span>
								</label>
							</div>
						</div>
						<div class="col-12 col-sm-10 col-md-1">
							<div class="form-group">
								{{ Form::label(null, 'Язык') }} <br/>
								{{ Form::select('lang', $langsArray ?? [], null, ['class' => 'form-control']) }}
							</div>
						</div>
	          <div class="col-12 col-md-4 col-md-5">
	            <div class="form-group">
								{{ Form::label(null, 'Дата публикации') }}
								{{ Form::text('published_date', date('Y-m-d'), ['id' => 'datepicker', 'class' => 'form-control']) }}
	            </div>
	          </div>
	          <div class="col-12 col-md-4 col-md-5">
	            <div class="form-group">
								{{ Form::label(null, 'Время публикации') }}
								{{ Form::text('published_time', date('H:i'), ['class' => 'form-control timepicker']) }}
	            </div>
	          </div>

	        </div>

					<div class="row">
						<div class="col-12 col-sm-4">
							<div class="form-group">
								{{ Form::label(null, 'Имя') }}
								{{ Form::text('name', null, ['class' => 'form-control']) }}
							</div>
						</div>
						<div class="col-12 col-sm-4">
							<div class="form-group">
								{{ Form::label(null, 'Фамилия') }}
								{{ Form::text('surname', null, ['class' => 'form-control']) }}
							</div>
						</div>
						<div class="col-12 col-sm-4">
							<div class="form-group">
								{{ Form::label(null, 'E-mail') }}
								{{ Form::text('email', null, ['class' => 'form-control']) }}
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="form-group">
								{{ Form::label(null, 'Тема') }}
								{{ Form::text('theme', null, ['class' => 'form-control']) }}
							</div>
						</div>

						<div class="col-12">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item"><a class="nav-link active show" href="#sub-tab-question" data-toggle="tab">Вопрос</a></li>
								<li class="nav-item"><a class="nav-link" href="#sub-tab-answer" data-toggle="tab">Ответ</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active show"  id="sub-tab-question" role="tabpanel">
									{{ Form::textarea('message', null, ['class' => 'tinymce']) }}
								</div>
								<div class="tab-pane"  id="sub-tab-answer" role="tabpanel">
									{{ Form::textarea('answer', null, ['class' => 'tinymce']) }}
								</div>
							</div>

						</div>
					</div>

				</form>
			</div>
		</div>
@endsection

@section('js')
	<script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
	<script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>
	<script src="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.js" charset="utf-8"></script>
	<script src="/avl/js/modules/settings/gb/gb.js" charset="utf-8"></script>
@endsection
