<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use LaravelLocalization;
use Carbon\Carbon;

class Polls extends Model
{
	use ModelTrait;

	protected $table = 'polls';

	protected $modelName = __CLASS__;

	protected $lang = null;

	protected $appends = ['path', 'title'];

	public function __construct ()
	{
		$this->lang = LaravelLocalization::getCurrentLocale();
	}

	public function childrens ()
	{
		return $this->hasMany(Polls::class, 'parent_id', 'id');
	}

	public function questions ()
	{
		return $this->hasMany(Polls::class, 'parent_id', 'id');
	}

	public function questionVotes ()
	{
		return $this->hasMany(PollVotes::class, 'question_id', 'id');
	}

	public function votes ()
	{
		return $this->hasMany(PollVotes::class, 'answer_id', 'id');
	}

	public function scopeGood ($query)
  {
    return $query->whereGood(true);
  }

	public function getPathAttribute ()
	{
		return route('admin.settings.sections.polls.edit', ['id' => $this->section_id, 'poll' => $this->id]);
	}

	public function getTitleAttribute ($value, $lang = null) {
    $name = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'title_' . $name}) ? $this->{'title_' . $name} : $this->title_ru ;
  }

	public function isVoted ($question, $request)
	{
		$isVoted = $question->questionVotes()->where(function ($query) use($request) {
			$yesterday = Carbon::yesterday()->format('Y-m-d') . ' ' . Carbon::now()->format('H:i:s');
			$query->where(function ($q) use ($request) {
				$q->where('ip', $request->ip())->orWhere('token', $request->cookie('token') ?? null);
			})->where('created_at', '>', $yesterday);
		})->first();

		return $isVoted ? true : false;
	}
}
