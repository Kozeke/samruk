<?php namespace App\Http\Controllers\Site\Sections;

use App\Http\Controllers\Site\Sections\SectionsController;
use Illuminate\Http\Request;
use App\Models\{ Polls, PollVotes };
use Validator;
use View;

class PollsController extends SectionsController
{
	public function index (Request $request)
	{
		$template = 'site.templates.polls.full.' . $this->getTemplateFileName($this->section->current_template->file_full) ?? 'default';

		$template = (View::exists($template)) ? $template : 'site.templates.polls.full.default';

		if ($request->ajax()) { return $this->getQuestions($request->input('poll'), $request); }

		$polls = $this->section->polls()->whereNull('parent_id')->good()->get();

		return view($template, [
			'polls' => $polls
		]);
	}

	public function store (Request $request)
	{

		$answer = Polls::find($request->input('answer'));

		if (!is_null($answer)) {

			$vote = new PollVotes();

			$vote->poll_id = $request->input('poll');
			$vote->question_id = $answer->parent_id;
			$vote->answer_id = $answer->id;
			$vote->ip = $request->ip();
			$vote->token = $request->cookie('token') ?? null;
			if ($vote->save()) {
				return ['success' => 'Ваш голоспринят'];
			}
		}

		return ['error' => 'Произошла внутренняя ошибка.'];
	}

	public function getQuestions ($poll = null, $request)
	{
		$return = [];
		if (!is_null($poll)) {
			$questions = Polls::where('parent_id', $poll)->good()->withCount('questionVotes')->get();

			if ($questions->count() > 0) {
				foreach ($questions as $question) {
					$allVotes = $question->question_votes_count;

					$childrens = [];
					$answers = $question->childrens()->good()->withCount('votes')->orderBy('sind', 'asc')->get();
					if ($answers->count() > 0) {
						foreach ($answers as $answer) {
							$childrens[] = [
								'id' => $answer->id,
								'title' => $answer->title,
								'percent' => (($allVotes > 0) && ($answer->votes_count > 0)) ? round((($answer->votes_count/$allVotes) * 100), 2) : 0
							];
						}
					}
					
					$return[] = [
						'id' => $question->id,
						'title' => $question->title,
						'childrens' => $childrens,
						'isVoted' => $question->isVoted($question, $request)
					];
				}
			}

		}
		return $return;
	}
}
