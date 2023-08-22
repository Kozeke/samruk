@extends('avl.default')

@section('css')
	<link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
	<link rel="stylesheet" href="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.css">
@endsection

@section('main')
		<div class="card">
			<div class="card-header">
					<i class="fa fa-align-justify"></i> Редактирование : {{ str_limit($object->title_ru, 100) }}
					<div class="card-actions">
						<a href="{{ route('admin.settings.sections.objects.index', [ 'id' => $section->id ]) }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
						<button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить изменения"><i class="fa fa-floppy-o"></i></button>
					</div>
			</div>

			<div class="card-body">
				<form action="{{ route('admin.settings.sections.objects.update', [ 'id' => $section->id, 'object' => $object->id ]) }}" method="post" id="submit">
					{!! csrf_field(); !!}
					{{ method_field('PUT') }}
					<input id="section_id" type="hidden" name="section_id" value="{{ $section->id }}">
					<input id="object_id" type="hidden" name="object_id" value="{{ $object->id }}">

					<div class="row">
						<div class="col-6 col-md-3">
							<div class="form-group">
								{{ Form::label(null, 'Дата публикации') }}
								{{ Form::text('published_at', date('Y-m-d', strtotime($object->published_at)), ['id' => 'datepicker', 'class' => 'form-control']) }}
							</div>
						</div>
						<div class="col-6 col-md-3">
							<div class="form-group">
								{{ Form::label(null, 'Время публикации') }}
								{{ Form::text('published_time', date('H:i', strtotime($object->published_at)), ['class' => 'form-control timepicker']) }}
							</div>
						</div>
						<div class="col-6 col-md-3">
							<div class="form-group">
								{{ Form::label(null, 'Программа') }}
								{{ Form::select('program', trans('objects.programs', [], 'ru'), $object->program ?? null, ['placeholder' => 'Выберите программу', 'class' => 'form-control']) }}
							</div>
						</div>
						<div class="col-6 col-md-3">
							<div class="form-group">
								{{ Form::label(null, 'Тип объекта') }}
								{{ Form::select('type', trans('objects.types', [], 'ru'), $object->type ?? null, ['placeholder' => 'Выберите тип объекта', 'class' => 'form-control']) }}
							</div>
						</div>
						@if ($section->rubric == true)
							<div class="col-12">
								<div class="form-group">
									{{ Form::label(null, 'Рубрика') }}
									{{ Form::select('rubric_id', $rubrics, $object->rubric_id ?? null, ['placeholder' => 'Выберите рубрику', 'class' => 'form-control']) }}
								</div>
							</div>
						@endif
					</div>

					<ul class="nav nav-tabs" role="tablist">
						@foreach($langs as $lang)
							<li class="nav-item"><a class="nav-link @if($lang->key == 'ru') active show @endif" href="#title_{{ $lang->key }}" data-toggle="tab">{{ $lang->name }}</a></li>
						@endforeach
						<li class="nav-item"><a class="nav-link" href="#image" data-toggle="tab">Изображения</a></li>
						<li class="nav-item"><a class="nav-link" href="#file" data-toggle="tab">Файлы</a></li>
						<li class="nav-item"><a class="nav-link" href="#video" data-toggle="tab">Видео</a></li>
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
													{{ Form::hidden('good_' . $lang->key, false) }}
													<label class="switch switch-3d switch-primary">
														{{ Form::checkbox('good_' . $lang->key, 1, $object->{'good_' . $lang->key}, ['class' => 'switch-input']) }}
														<span class="switch-label"></span>
														<span class="switch-handle"></span>
													</label>
												</div>
											</div>
											<div class="col-9 col-sm-11">
												<div class="form-group">
													{{ Form::label('Название') }}
													{{ Form::text('title_' . $lang->key, $object->{'title_' . $lang->key} ?? null, ['class' => 'form-control']) }}
												</div>
											</div>
											<div class="col-12">
												{{ Form::textarea('about_' . $lang->key, $object->{'about_' . $lang->key} ?? null, ['class' => 'tinymce']) }}
											</div>
										</div>
									</div>

									<div class="tab-pane"  id="sub-tab_{{ $lang->key }}-infrastructure" role="tabpanel">
										{{ Form::textarea('infrastructure_' . $lang->key, $object->{'infrastructure_' . $lang->key} ?? null, ['class' => 'tinymce']) }}
									</div>

									<div class="tab-pane"  id="sub-tab_{{ $lang->key }}-plans" role="tabpanel">
										{{ Form::textarea('plans_' . $lang->key, $object->{'plans_' . $lang->key} ?? null, ['class' => 'tinymce']) }}
									</div>

									<div class="tab-pane"  id="sub-tab_{{ $lang->key }}-circs" role="tabpanel">
										{{ Form::textarea('circs_' . $lang->key, $object->{'circs_' . $lang->key} ?? null, ['class' => 'tinymce']) }}
									</div>

									<div class="tab-pane"  id="sub-tab_{{ $lang->key }}-developer" role="tabpanel">
										{{ Form::textarea('developer_' . $lang->key, $object->{'developer_' . $lang->key} ?? null, ['class' => 'tinymce']) }}
									</div>

									<div class="tab-pane"  id="sub-tab_{{ $lang->key }}-location" role="tabpanel">
										{{ Form::textarea('location_' . $lang->key, $object->{'location_' . $lang->key} ?? null, ['class' => 'tinymce']) }}
									</div>
								</div>
							</div>
						@endforeach

						<div class="tab-pane" id="image" role="tabpanel">
							<div class="block--file-upload">
								<input id="upload--photos" name="upload" type="file" />
							</div>
							<div class="row">
								<div class="photo--news col-lg-12">
									<div class="row">
										<ul id="sortable" class="list-unstyled">
											@php $images = $object->media('image')->orderBy('sind', 'DESC')->get(); @endphp
											@if ($images->count() > 0)
												@foreach ($images as $image)
													<li class="col-md-2 float-left" id="mediaSortable_{{ $image['id'] }}">
														<div class="card">
															<div class="card-header">
																<div class="row">
																	@php $classImage = ($image['good'] == 0) ? '-slash' : '' ; @endphp
																	@php $mainImage  = ($image['main'] == 1) ? 'fa-check-circle-o' : 'fa-circle-o' ; @endphp
																	<div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="change--status" data-model="Media" data-id="{{ $image['id'] }}"><i class="fa fa-eye<?=$classImage?>"></i></a></div>
																	<div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="toMainPhoto" data-model="Media" data-id="{{ $image['id'] }}"><i class="fa <?=$mainImage?>"></i></a></div>
																	<div class="col-lg-4 col-md-4 col-sm-4 text-center"> <a href="#" class="deleteMedia" data-model="Media" data-id="{{ $image['id'] }}"><i class="fa fa-trash-o"></i></a> </div>
																</div>
															</div>
															<div class="card-body p-0">
																<img src="/image/resize/260/230/{{ $image['link'] }}">

																<div class="col-12">
																	<div class="row bg-light p-2">
																		@foreach($langs as $lang)
																			<div class="col-lg-4 col-md-4 col-sm-4 text-center">
																				<a href="#" class="change--switch" data-lang="{{ $lang->key }}" data-id="{{ $image['id'] }}">
																					<i class="icon--language icon--language-{{ $lang->key }} @if (!$image->{'switch_' . $lang->key}){{ 'disabled' }}@endif"></i>
																				</a>
																			</div>
																		@endforeach
																	</div>
																</div>
															</div>
															<div class="card-footer p-0 bg-white">
																<ul class="nav nav-tabs">
																	@foreach($langs as $lang)
																		<li class="nav-item p-0">
																			<a class="nav-link @if($lang->key == 'ru') active show @endif" href="#tab--title-item-{{ $image['id'] }}-{{ $lang->key }}" data-toggle="tab" aria-expanded="false">
																				{{ $lang->key }}
																			</a>
																		</li>
																	@endforeach
																</ul>
																<div class="tab-content">
																	@foreach($langs as $lang)
																		<div class="p-0 tab-pane @if($lang->key == 'ru') active show @endif" id="tab--title-item-{{ $image['id'] }}-{{ $lang->key }}">
																			<textarea class="form-control border-0 media--{{ $image['id'] }}" data-lang="{{ $lang->key }}" placeholder="{{ $lang->key }}">{{ $image['title_' . $lang->key] }}</textarea>
																			<button type="button" class="btn btn-primary btn-sm btn-block save--media-content" data-id="{{ $image['id'] }}">Save</button>
																		</div>
																	@endforeach
																</div>
															</div>
														</div>
													</li>
												@endforeach
											@endif
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="file" role="tabpanel">
							<div class="block--file-upload">
								<div class="form-group">
									<select class="form-control" id="select--language-file">
										@foreach($langs as $lang)
											<option value="{{ $lang->key }}">{{ $lang->key }}</option>
										@endforeach
									</select>
								</div>
								<input id="upload--files" name="upload" type="file" />
							</div>
							<div class="row files--news">
								<div class="col-md-12">
									<ul id="sortable-files" class="list-group">
										@php $files = $object->media('file')->orderBy('sind', 'DESC')->get(); @endphp
										@if ($files->count() > 0)
											@foreach ($files as $file)
													@php $classFile = ($file['good'] == 0) ? '-slash' : '' @endphp
													<li class="col-md-12 list-group-item files--item" id="mediaSortable_{{ $file['id'] }}">
														<div class="img-thumbnail">
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text"><a href="" class="change--lang" data-id="{{ $file['id'] }}"><img src="/avl/img/icons/flags/{{ $file['lang'] }}--16.png"></a></span>
																	<span class="input-group-text" style="cursor: move;"><i class="fa fa-arrows"></i></span>
																	<span class="input-group-text"><a href="#" class="change--status" data-model="Media" data-id="{{ $file['id'] }}"><i class="fa @if($file['good'] == 1){{ 'fa-eye' }}@else{{ 'fa-eye-slash' }}@endif"></i></a></span>
																	<span class="input-group-text"><a href="/file/save/{{ $file['id'] }}" target="_blank"><i class="fa fa-download"></i></a></span>
																	<span class="input-group-text"><a href="#" class="deleteMedia" data-model="Media" data-id="{{ $file['id'] }}"><i class="fa fa-trash-o"></i></a></span>
																</div>
																<input type="text" id="title--{{ $file['id'] }}" class="form-control" value="{{ $file['title_' . $file['lang'] ] }}">
																<div class="input-group-append">
																	<span class="input-group-text"><a href="#" class="save--file-name" data-id="{{ $file['id'] }}"><i class="fa fa-floppy-o"></i></a></span>
																</div>
															</div>
														</div>
													</li>
											@endforeach
										@endif
									</ul>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="video" role="tabpanel">
							<div class="form-group col-12 save--link--video p-0">
								<div class="img-thumbnail">
									<div class="input-group">
										<div class="input-group-prepend">
											<select class="form-control" id="select--language-video">
												@foreach($langs as $lang)
													<option value="{{ $lang->key }}">{{ $lang->key }}</option>
												@endforeach
											</select>
										</div>
										<input id="title_video" placeholder="Название" type="text" class="form-control" name="news_video_title">
										<input id="link_video" placeholder="Ссылка" type="text" class="form-control" name="news_video_link">
										<div class="input-group-append">
											<a href="#" class="save--video_link" data-id="{{ $section->id }}" data-object_id="{{ $object->id }}"><span class="btn btn-success pl-3 pr-3"><i class="fa fa-floppy-o"></i></span></a>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row video--news">
								<div class="col-md-12">
									<ul id="sortable-video" class="list-group">
										@php $videos = $object->media('video')->orderBy('sind', 'DESC')->get(); @endphp
										@if ($videos->count() > 0)
											@foreach ($videos as $video)
													@php $classFile = ($video['good'] == 0) ? '-slash' : '' @endphp
													<li class="col-md-12 list-group-item files--item" id="videoSortable_{{ $video['id'] }}">
														<div class="img-thumbnail">
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text"><img src="/avl/img/icons/flags/{{ $video['lang'] }}--16.png" alt=""></a></span>
																	<span class="input-group-text"><a href="#" class="change--status" data-model="Media" data-id="{{ $video['id'] }}"><i class="fa @if($video['good'] == 1){{ 'fa-eye' }}@else{{ 'fa-eye-slash' }}@endif"></i></a></span>
																	<span class="input-group-text"><a href="#" class="deleteVideo" data-model="Media" data-id="{{ $video['id'] }}"><i class="fa fa-trash-o"></i></a></span>
																</div>
																<input type="text" id="title--{{ $video['id'] }}" class="form-control" value="{{ $video['title_' . $video['lang'] ] }}">
																<input type="text" id="link--{{ $video['id'] }}" class="form-control" value="{{ $video['link'] }}">
																<div class="input-group-append">
																	<span class="input-group-text"><a href="#" class="update--video" data-id="{{ $video['id'] }}"><i class="fa fa-floppy-o"></i></a></span>
																</div>
															</div>
														</div>
													</li>
											@endforeach
										@endif
									</ul>
								</div>
							</div>

						</div>

					</div></br>
				</form>
			</div>

			<div class="card-footer position-relative">
					<i class="fa fa-align-justify"></i> Редактирование : {{ str_limit($object->title_ru, 100) }}
					<div class="card-actions">
						<a href="{{ route('admin.settings.sections.objects.index', [ 'id' => $section->id ]) }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
						<button type="submit" form="submit" name="button" value="save" class="btn btn-success pl-3 pr-3" style="width: 70px;" title="Сохранить изменения"><i class="fa fa-floppy-o"></i></button>
					</div>
			</div>
		</div>
@endsection

@section('js')
	<script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
	<script src="/avl/js/uploadifive/jquery.uploadifive.min.js" charset="utf-8"></script>

	<script src="/avl/js/modules/settings/objects/edit.js" charset="utf-8"></script>
	<script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>
	<script src="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.js" charset="utf-8"></script>
@endsection
