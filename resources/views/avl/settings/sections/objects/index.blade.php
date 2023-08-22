@extends('avl.default')

@section('js')
	<link rel="stylesheet" href="/avl/js/datetimepicker/jquery.datetimepicker.css">
	<script src="/avl/js/dateformat.js" charset="utf-8"></script>
	<script src="/avl/js/datetimepicker/build/jquery.datetimepicker.full.min.js" charset="utf-8"></script>

	<script src="/avl/js/modules/settings/objects/index.js" charset="utf-8"></script>
@endsection

@section('main')
		<div class="card">
				<div class="card-header">
						<i class="fa fa-align-justify"></i> {{$section->name_ru}}
						@can('create', $section)
							<div class="card-actions">
								<a href="{{ route('admin.settings.sections.objects.create', ['id' => $id]) }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
							</div>
						@endcan
				</div>
				<div class="card-body" style="owerflow:hidden; owerflow-x: true;">

						<form action="" method="get" class="mb-4">
							<div class="row">
								@if ($section->rubric == true)
									<div class="col-3">
										{{ Form::select('rubric', $rubrics, $request->input('rubric'), ['placeholder' => 'Все объекты', 'class' => 'form-control']) }}
									</div>
								@endif
								<div class="col-3">
									{{ Form::select('program', trans('objects.programs', [], 'ru'), $request->input('program'), ['placeholder' => 'Все программы', 'class' => 'form-control']) }}
								</div>
								<div class="col-3">
									{{ Form::select('type', trans('objects.types', [], 'ru'), $request->input('type'), ['placeholder' => 'Все типы', 'class' => 'form-control']) }}
								</div>
								<div class="col-3">
									<div class="btn-group w-100" role="group">
										<a href="{{ route('admin.settings.sections.objects.index', ['id' => $id]) }}" class="btn btn-primary w-100">Сбросить</a>
										<button type="submit" class="btn btn-success w-100">Показать</button>
									</div>
								</div>
							</div>
						</form>

						@if ($objects)
								@php $iteration = 30 * ($objects->currentPage() - 1); @endphp
								<table class="table table-bordered">
										<thead>
											<tr>
													<th width="50" class="text-center">#</th>
													@foreach($langs as $lang)
														<th class="text-center" style="width: 20px">{{ $lang->key }}</th>
													@endforeach
													<th class="text-center">Объект</th>
													@if($section->rubric == true)
														<th class="text-center" style="width: 160px;">Рубрика</th>
													@endif
													<th class="text-center" style="width: 160px">Программа</th>
													<th class="text-center" style="width: 160px">Тип объекта</th>
													<th class="text-center" style="width: 160px">Дата публикации</th>
													<th class="text-center" style="width: 100px;">Действие</th>
											</tr>
										</thead>
										<tbody>
												@foreach ($objects as $object)
													<tr class="position-relative" id="objects--item-{{ $object->id }}">
														<td class="text-center">{{ ++$iteration }}</td>
														@foreach($langs as $lang)
															<td class="text-center" style="width: 20px">
																<a class="change--status" href="#" data-id="{{ $object->id }}" data-model="Objects" data-lang="{{$lang->key}}">@if ($object->{'good_' . $lang->key})<i class="fa fa-eye"></i>@else <i class="fa fa-eye-slash"></i> @endif</a>
															</td>
														@endforeach
														<td>
															<b>{{ $object->title_ru }}</b><br/>
															<span class="text-secondary">{{ str_limit(strip_tags($object->about_ru), 300) }}</span>
														</td>
														@if($section->rubric == true)
															<td class="text-center">@if(!is_null($object->rubric)){{ $object->rubric->title_ru }}@endif</td>
														@endif
														<td class="text-center">@if(!is_null($object->program)){{ trans('objects.programs.' . $object->program, [], 'ru') }}@endif</td>
															<td class="text-center">@if(!is_null($object->type)){{ trans('objects.types.' . $object->type, [], 'ru') }}@endif</td>
														<td class="text-center">
															{{ date('Y-m-d H:i', strtotime($object->published_at)) }}
														</td>
														<td class="text-right">
															<div class="btn-group" role="group">
																{{-- @can('view', $section) <a href="{{ route('admin.settings.sections.objects.show', ['id' => $id, 'object' => $object->id]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a> @endcan --}}
																@can('update', $section) <a href="{{ route('admin.settings.sections.objects.edit', ['id' => $id, 'object' => $object->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a> @endcan
																@can('delete', $section) <a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a> @endcan
															</div>
															@can('delete', $section)
																<div class="remove-message">
																		<span>Вы действительно желаете удалить запись?</span>
																		<span class="remove--actions btn-group btn-group-sm">
																				<button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
																				<button class="btn btn-outline-danger remove--object" data-id="{{ $object->id }}" data-section="{{ $id }}"><i class="fa fa-trash"></i> Да</button>
																		</span>
																</div>
															 @endcan
														</td>
													</tr>
												@endforeach
										</tbody>
								</table>
								<div class="d-flex justify-content-end">
										{{ $objects->appends($_GET)->links('vendor.pagination.bootstrap-4') }}
								</div>
						@endif
				</div>
		</div>
@endsection
