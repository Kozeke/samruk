@extends('avl.default')

@section('js')
  <script src="/avl/js/modules/settings/sections/section.js" charset="utf-8"></script>
  <script src="/avl/js/modules/settings/calculator/calculator.js" charset="utf-8"></script>
@endsection

@section('main')
	<div class="card">
			<div class="card-header">
					<i class="fa fa-align-justify"></i> Жилые помещения : <b>[{{ $complex->title_ru }}]</b>
					<a href="{{ url('/admin/settings/sections/'.$section->id.'/calculator') }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
						<div class="card-actions">
							<a href="{{ url('/admin/settings/sections/'.$section->id.'/calculator/'.$complex->id.'/apartment/create') }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
						</div>
			</div>
			<div class="card-body">
					@if ($apartments)
							<table class="table table-bordered">
									<thead>
											<tr>
												{{-- @foreach($langs as $lang)
												<th class="text-center" style="width: 20px">{{ $lang->key }}</th>
												@endforeach --}}
													<th class="text-center">Тип жилого помещения</th>
													<th class="text-center" style="width: 50px">Квадратура</th>
													<th class="text-center" style="width: 160px">Создан</th>
													<th class="text-center" style="width: 100px;">Действие</th>
											</tr>
									</thead>
									<tbody>
											@foreach ($apartments as $apartment)
												<tr class="position-relative" id="apartment--item-{{ $apartment->id }}">
													{{-- @foreach($langs as $lang)
													@php $good = 'good_' . $lang->key; @endphp
													<td class="text-center" style="width: 20px">
														<a class="change--status" href="#" data-id="{{ $complex->id }}" data-model="Links" data-lang="{{$lang->key}}">@if ($complex->$good)<i class="fa fa-eye"></i>@else <i class="fa fa-eye-slash"></i> @endif</a>
													</td>
													@endforeach --}}
													<td>{{ $apartment->name_ru }}</td>
													<td>{{ $apartment->measure }}</td>
													<td>{{ $apartment->created_at }}</td>
													<td class="text-right">
														<div class="btn-group" role="group">
														<a href="{{ route('calculator.apartment_edit', ['id' => $section->id, 'complexe_id' => $complex->id, 'apartment_id' => $apartment->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a>
														<a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a>
														</div>
															<div class="remove-message">
																<span>Вы действительно желаете удалить запись?</span>
																<span class="remove--actions btn-group btn-group-sm">
																		<button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
																		<button class="btn btn-outline-danger remove--apartment" data-complex="{{ $complex->id }}" data-id="{{ $apartment->id }}" data-section="{{ $section->id }}"><i class="fa fa-trash"></i> Да</button>
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
