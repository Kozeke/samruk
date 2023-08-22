@extends('avl.default')

@section('js')
	<script src="/avl/js/vue.min.js"></script>
	<script src="/avl/js/modules/settings/poll/edit.js" charset="utf-8"></script>
@endsection

@section('main')
	<div class="card" id="poll-instance">
		<div class="card-header">
			<i class="fa fa-align-justify"></i> Опрос:
			<div class="card-actions">
				<a href="{{ route('admin.settings.sections.polls.index', ['id' => $section->id]) }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
			</div>
		</div>

		<div class="card-body" >
			{{ Form::hidden(null, $section->id, ['id' => 'section--id']) }}
			{{ Form::hidden(null, $pollID, ['id' => 'poll--id']) }}

			<div class="row">
				<div class="col-12">
					<div class="border bg-light">
						<div class="d-flex" v-if="langs">
							<a v-for="lang in langs" v-bind:class="[currentLang == lang.key ? 'btn-secondary' : '', 'btn btn-default']" v-on:click="currentLang = lang.key"><i v-bind:class="['icon--language icon--language-' + lang.key]"></i></a>
						</div>
					</div>

					<div class="card mt-3">
						<div class="card-body p-3">
							<div class="row">

								{{-- Вопросы --}}
								<div class="col-6">
									<div class="card">
										<div class="card-header">
											<b>Вопросы</b>
											<span class="badge badge-pill badge-info float-right p-2">@[[ questions.records.length ]]@</span>
										</div>
										<div class="card-body pr-2 pl-2">
											<ul class="list-group" v-if="questions.records.length">

												<li v-bind:class="[(questions.current == question.id) || (questions.showAnswer == question.id) ? 'bg-light' : '', 'list-group-item']" v-for="question in questions.records">
													<a href="#" class="mr-2 change--status" :data-id="question.id" data-model="Polls"><i v-bind:class="[question.good ? 'fa-eye' : 'fa-eye-slash','fa']"></i></a>

													<span v-for="lang in langs" v-if="lang.key == currentLang">@[[ question['title_' + lang.key] ]]@</span>

													<span class="pull-right">
														<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
															<span class="btn btn-light">@[[ question.questions_count ]]@</span>
															<button type="button" class="btn btn-primary" title="Список ответов" v-on:click="getAnswers(question.id)">
																<i class="fa fa-list"></i>
															</button>
															<button type="button" class="btn btn-success" v-on:click="getQuestionForUpdate(question.id, $event)" title="Изменить">
																<i class="fa fa-pencil"></i>
															</button>
															<button type="button" class="btn btn-danger" v-on:click="removeQuestion(question.id)" title="Удалить">
																<i class="fa fa-trash-o"></i>
															</button>
														</div>
													</span>
												</li>

											</ul>
										</div>
										<div class="card-footer p-2">
											<div class="input-group">
												<input type="text"
															 v-for="lang in langs"
															 v-bind:class="[currentLang == lang.key ? 'd-block' : 'd-none', 'form-control']"
															 v-model="questions.createOrUpdate['title_' + lang.key]"
															 v-bind:placeholder="lang.name">

												<span class="input-group-append">
													<button class="btn btn-primary" type="button" v-if="!questions.current" v-on:click="storeOrUpdateQuestion()"><i class="fa fa-plus"></i></button>
													<button class="btn btn-success" type="button" v-if="questions.current" v-on:click="storeOrUpdateQuestion(questions.current)"><i class="fa fa-floppy-o"></i></button>
												</span>
											</div>
										</div>
									</div>
								</div>

								{{-- Ответы --}}
								<div class="col-6">
									<div class="card">
										<div class="card-header">
											<b>Варианты ответов</b>
											<span class="badge badge-pill badge-info float-right p-2">@[[ answers.records.length ]]@</span>
										</div>
										<div class="card-body">
											<ul class="list-group" v-if="answers.records.length">

												<li v-bind:class="[answers.current == answer.id ? 'bg-light' : '', 'list-group-item']" v-for="answer in answers.records">
													<a href="#" class="mr-2 change--status" :data-id="answer.id" data-model="Polls"><i v-bind:class="[answer.good ? 'fa-eye' : 'fa-eye-slash','fa']"></i></a>

													<span v-for="lang in langs" v-if="lang.key == currentLang">@[[ answer['title_' + lang.key] ]]@</span>

													<span class="pull-right">
														<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
															<span class="btn btn-light" :title="'Голосов: ' + answer.votes_count">@[[ answer.votes_count ]]@</span>
															<button type="button" class="btn btn-success" v-on:click="getAnswerForUpdate(answer.id, $event)" title="Изменить">
																<i class="fa fa-pencil"></i>
															</button>
															<button type="button" class="btn btn-danger" v-on:click="removeAnswer(answer.id)" title="Удалить">
																<i class="fa fa-trash-o"></i>
															</button>
														</div>
													</span>
												</li>

											</ul>
										</div>
										<div class="card-footer p-2" v-if="questions.showAnswer">
											<div class="input-group">
												<input type="text"
															 v-for="lang in langs"
															 v-bind:class="[currentLang == lang.key ? 'd-block' : 'd-none', 'form-control']"
															 v-model="answers.createOrUpdate['title_' + lang.key]"
															 v-bind:placeholder="lang.name">

												<span class="input-group-append">
													<button class="btn btn-primary" type="button" v-if="!answers.current" v-on:click="storeOrUpdateAnswer()"><i class="fa fa-plus"></i></button>
													<button class="btn btn-success" type="button" v-if="answers.current" v-on:click="storeOrUpdateAnswer(answers.current)"><i class="fa fa-floppy-o"></i></button>
												</span>
											</div>
										</div>
									</div>
								</div>

							</div>

						</div>
					</div>


				</div>
			</div>

			{{-- <div class="row">
				<div class="col-12">
					<pre class="border p-3 bg-light">@[[ questions.current ]]@</pre>
					<pre class="border p-3 bg-light">@[[ questions.current ]]@</pre>
					<pre class="border p-3 bg-light">@[[ questions.createOrUpdate ]]@</pre>
				</div>
			</div> --}}

		</div>

		<div class="card-footer position-relative">
				<i class="fa fa-align-justify"></i> Добавить опрос
				<div class="card-actions">
					<a href="{{ '#' }}" class="btn btn-default pl-3 pr-3" style="width: 70px;" title="Назад"><i class="fa fa-arrow-left"></i></a>
				</div>
		</div>
	</div>
@endsection
