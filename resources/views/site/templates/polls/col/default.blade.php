@section('js')
	<script src="/site/js/poll.js"></script>
@endsection

@if ($poll)
	@php $question = $poll->questions()->good()->orderBy('sind', 'DESC')->limit(1)->get(); @endphp

	@if ($question->count() > 0)
		<div class="poll" id="poll-instance" style="display: none;">
			<div class="poll__inner">
				{{ Form::hidden(null, $section->path, ['id' => 'poll-instance-path']) }}
				{{ Form::hidden(null, $poll->id, ['id' => 'poll-instance-poll--id']) }}

				<h3 class="title-block">{{ trans('translations.poll') }}</h3>

				<form class="poll__form" v-for="(question, index) in questions.slice(0,1)">
					<div class="poll__form-title">@[[ question.title ]]@</div>

					<div class="poll__form-fields" v-if="question.childrens.length > 0">
						<div class="form-field" v-for="(answer, key) in  question.childrens">
							<div class="form-check" v-if="!question.isVoted">
								<label class="form-check__label">
									<input type="radio" v-model="currentVote" :value="answer.id">
									<span>@[[ answer.title ]]@</span>
								</label>
							</div>

							<div v-else>
								<span>@[[ answer.title ]]@</span>

								<div class="poll__form-progress">
									<div class="poll__form-progress-bar" :style="{ width: answer.percent + '%' }">
										@[[ answer.percent + '%' ]]@
									</div>
								</div>
							</div>
						</div><!-- /.form-field -->
					</div>

					<div class="poll__form-submit" v-if="!question.isVoted">
						<button class="btn btn--square btn--text-left w-100" v-on:click="setVote" type="button">
							{{ trans('translations.poll_btn') }}
						</button>
					</div>
				</form>
			</div>
		</div><!-- /.poll -->
	@endif
@endif
