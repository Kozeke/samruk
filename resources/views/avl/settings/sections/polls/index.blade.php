@extends('avl.default')

@section('js')
	<script src="/avl/js/vue.min.js"></script>
	<script src="/avl/js/modules/settings/poll/index.js" charset="utf-8"></script>
@endsection

@section('main')
	<div class="card" id="poll-instance">
		<div class="card-header">
			<i class="fa fa-align-justify"></i> {{ $section->name_ru }}
			{{-- @can('create', $section)
				<div class="card-actions">
					<a href="{{ route('admin.settings.sections.polls.create', ['id' => $section->id]) }}" class="w-100 pl-3 pr-3"><i class="icon-plus" style="vertical-align: sub;"></i> Добавить</a>
				</div>
			@endcan --}}
		</div>

		<div class="card-body">

			<div class="border p-3 mb-3">
				{{ Form::hidden(null, $section->id, ['id' => 'section--id']) }}
				<div class="row">
					<div class="col-12">
						<div class="border bg-light">
							<div class="d-flex" v-if="langs">
								<a v-for="lang in langs" v-bind:class="[currentLang == lang.key ? 'btn-secondary' : '', 'btn btn-default']" v-on:click="currentLang = lang.key"><i v-bind:class="['icon--language icon--language-' + lang.key]"></i></a>
							</div>
						</div>

						<div class="border mt-2 p-2 bg-light">
							<div class="input-group">
								<input type="text"
											 v-for="lang in langs"
											 v-bind:class="[currentLang == lang.key ? 'd-block' : 'd-none', 'form-control']"
											 v-model="createOrUpdate['title_' + lang.key]"
											 v-bind:placeholder="lang.name">

								<span class="input-group-append">
									<button class="btn btn-primary" type="button" v-if="!pollID" v-on:click="storeOrUpdate"><i class="fa fa-plus"></i></button>
									<button class="btn btn-success" type="button" v-if="pollID" v-on:click="storeOrUpdate"><i class="fa fa-floppy-o"></i></button>
								</span>
							</div>
						</div>

					</div>
				</div>
			</div>

			<ul class="list-group" v-if="polls.length">
				<li v-bind:class="[poll.id == pollID ? 'bg-light' : '', 'list-group-item']" v-for="poll in polls">
					<a href="#" class="mr-2 change--status" :data-id="poll.id" data-model="Polls"><i v-bind:class="[poll.good ? 'fa-eye' : 'fa-eye-slash','fa']"></i></a>

					<span v-for="lang in langs" v-if="lang.key == currentLang">@[[ poll['title_' + lang.key] ]]@</span>

					<span class="pull-right">
						<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
							<span class="btn btn-light">@[[ poll.questions_count ]]@</span>
							<a :href="poll.path" class="btn btn-primary" title="Список вопросов"><i class="fa fa-list"></i></a>
							<button type="button" class="btn btn-success" v-on:click="getForUpdate(poll.id, $event)" title="Изменить"><i class="fa fa-pencil"></i></button>
							<button type="button" class="btn btn-danger" v-on:click="removePoll(poll.id, $event)" title="Удалить"><i class="fa fa-trash-o"></i></button>
						</div>
					</span>
				</li>
			</ul>

			{{-- <div class="row">
				<div class="col-12">
					<pre class="border p-3 bg-light">@[[ pollID ]]@</pre>
					<pre class="border p-3 bg-light">@[[ createOrUpdate ]]@</pre>
					<pre class="border p-3 bg-light">@[[ polls ]]@</pre>
				</div>
			</div> --}}
		</div>
	</div>
@endsection
