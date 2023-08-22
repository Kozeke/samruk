@extends('avl.default')

@section('js')
  <script src="/avl/js/modules/settings/sections/section.js" charset="utf-8"></script>
  <script src="/avl/js/modules/settings/calculator/calculator.js" charset="utf-8"></script>
@endsection

@section('main')
	<div class="card">
			<div class="card-header">
					<i class="fa fa-align-justify"></i> {{$section->name_ru}}
						<div class="card-actions">
							<a href="{{ url('/admin/settings/sections/'.$section->id.'/calculator/create') }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
						</div>
			</div>
			<div class="card-body">
					@if ($complexes)
							<table class="table table-bordered">
									<thead>
											<tr>
												{{-- @foreach($langs as $lang)
												<th class="text-center" style="width: 20px">{{ $lang->key }}</th>
												@endforeach --}}
													<th class="text-center">Наименование жилого комплекса</th>
													<th class="text-center" style="width: 160px">Создан</th>
													<th class="text-center" style="width: 100px;">Действие</th>
											</tr>
									</thead>
									<tbody>
											@foreach ($complexes as $complex)
												<tr class="position-relative" id="complexe--item-{{ $complex->id }}">
													{{-- @foreach($langs as $lang)
													@php $good = 'good_' . $lang->key; @endphp
													<td class="text-center" style="width: 20px">
														<a class="change--status" href="#" data-id="{{ $complex->id }}" data-model="Links" data-lang="{{$lang->key}}">@if ($complex->$good)<i class="fa fa-eye"></i>@else <i class="fa fa-eye-slash"></i> @endif</a>
													</td>
													@endforeach --}}
													<td>{{ $complex->title_ru }}</td>
													<td>{{ $complex->created_at }}</td>
													<td class="text-right">
														<div class="btn-group" role="group">
														<a href="{{ route('calculator.show', ['id' => $section->id, 'complexe_id' => $complex->id]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a>
														<a href="{{ route('calculator.edit', ['id' => $section->id, 'complexe_id' => $complex->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a>
														<a href="{{ route('calculator.apartment_index', ['id' => $section->id, 'complexe_id' => $complex->id]) }}" class="btn btn btn-warning" title="Жилые помещения"><i class="fa fa-home"></i></a>
														<a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a>
														</div>
															<div class="remove-message">
																<span>Вы действительно желаете удалить запись?</span>
																<span class="remove--actions btn-group btn-group-sm">
																		<button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
																		<button class="btn btn-outline-danger remove--complexe" data-id="{{ $complex->id }}" data-section="{{ $section->id }}"><i class="fa fa-trash"></i> Да</button>
																</span>
															</div>
													</td>
												</tr>
											@endforeach
									</tbody>
							</table>
					@endif
			</div>
	</div>
@endsection
