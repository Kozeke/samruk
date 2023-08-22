@extends('avl.default')

@section('js')
  <script src="/avl/js/modules/settings/gb/gb.js" charset="utf-8"></script>
@endsection

@section('main')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> {{ $section->name_ru }}
            @can('create', App\Models\Gb::class)
              <div class="card-actions">
                <a href="{{ route('admin.settings.sections.gb.create', ['id' => $section->id]) }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
              </div>
            @endcan
        </div>
        <div class="card-body">
            <form action="" method="get" class="mb-4">
                <div class="row">
                    <div class="col-5">
                        <input type="text" name="name" value="" class="form-control" placeholder="Имя">
                    </div>
                    <div class="col-5">
                        <input type="text" name="email" value="" class="form-control" placeholder="E-mail">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary w-100">Показать</button>
                    </div>
                </div>
            </form>

					<table class="table table-bordered table-dashed">
						<thead>
							<tr>
								<th width="50" class="text-center">#</th>
								<th><i class="fa fa-eye"></i></th>
								<th>Имя</th>
								<th>E-mail</th>
								<th>Вопрос</th>
								<th class="text-center" style="width: 160px">Дата создания</th>
								<th class="text-center" style="width: 160px">Дата публикации</th>
								<th class="text-center" style="width: 100px;">Действие</th>
							</tr>
						</thead>
						<tbody>
							@if ($records->count() > 0)
								@php $iteration = 30 * ($records->currentPage() - 1); @endphp
								@foreach ($records as $record)
									<tr class="position-relative" id="gb--item-{{ $record->id }}">
										<td class="text-center">{{ ++$iteration }}</td>
										<td class="text-center"><a class="change--status" href="#" data-id="{{ $record->id }}" data-model="Gb"><i class="fa {{ ($record->good) ? 'fa-eye' : 'fa-eye-slash' }}"></i></a></td>
										<td>{{ $record->name }}</td>
										<td>{{ $record->email }}</td>
										<td>{{ str_limit(strip_tags($record->message), 200) }}</td>
										<td class="text-center">{{ date('Y-m-d H:i', strtotime($record->created_at)) }}</td>
										<td class="text-center">
											@if(is_null($record->published_at))
												Не опубликовано
											@else
												{{ date('Y-m-d H:i', strtotime($record->published_at)) }}
											@endif
										</td>
										<td class="text-center">
											<div class="btn-group" role="group">
												@can('view', $section) <a href="{{ route('admin.settings.sections.gb.show', ['id' => $section->id, 'gb' => $record->id]) }}" class="btn btn btn-outline-primary" title="Просмотр"><i class="fa fa-eye"></i></a> @endcan
												@can('update', $section) <a href="{{ route('admin.settings.sections.gb.edit', ['id' => $section->id, 'gb' => $record->id]) }}" class="btn btn btn-outline-success" title="Изменить"><i class="fa fa-edit"></i></a> @endcan
												@can('delete', $section) <a href="#" class="btn btn btn-outline-danger remove--record" title="Удалить"><i class="fa fa-trash"></i></a> @endcan
											</div>
											@can('delete', $section)
												<div class="remove-message">
														<span>Вы действительно желаете удалить запись?</span>
														<span class="remove--actions btn-group btn-group-sm">
																<button class="btn btn-outline-primary cancel"><i class="fa fa-times-circle"></i> Нет</button>
																<button class="btn btn-outline-danger remove--gb" data-id="{{ $record->id }}" data-section="{{ $section->id }}"><i class="fa fa-trash"></i> Да</button>
														</span>
												</div>
											 @endcan
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="7">Нет вопросов</td>
								</tr>
							@endif
						</tbody>
					</table>
					<div class="d-flex justify-content-end">
							{{ $records->appends($_GET)->links('vendor.pagination.bootstrap-4') }}
					</div>
        </div>
    </div>
@endsection
