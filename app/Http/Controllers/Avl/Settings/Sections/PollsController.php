<?php namespace App\Http\Controllers\Avl\Settings\Sections;

use App\Http\Controllers\Avl\AvlController;
	use App\Models\{ Langs, Sections, Polls };
	use App\Traits\SectionsTrait;
	use Illuminate\Http\Request;

class PollsController extends AvlController
{
	protected $langs = null;

	protected $section = null;

	public function __construct (Request $request)
	{

		parent::__construct($request);

		$this->langs = Langs::get();

		$this->section = $request->id ? Sections::whereId($request->id)->firstOrFail() : null;
	}

	public function index($id, Request $request)
	{
		$this->authorize('view', $this->section);

		return view('avl.settings.sections.polls.index', [
			'section' => $this->section,
			'langs' => $this->langs
		]);
	}

	public function create($id)
	{
		$this->authorize('create', $this->section);

		return view('avl.settings.sections.polls.create', [
			'langs' => $this->langs,
			'section' => $this->section
		]);
	}

	public function store($id, Request $request)
	{
		$this->authorize('create', $this->section);
		if ($request->input('parent_id')) {
			$order = Polls::where('parent_id', $request->input('parent_id'))->orderBy('sind', 'desc')->first();
		} else {
			$order = Polls::whereNull('parent_id')->orderBy('sind', 'desc')->first();
		}

		$poll = new Polls();
		$poll->good = true;
		$poll->section_id = $this->section->id;
		$poll->sind = !is_null($order) ? $order->sind + 1 : 1;
		$poll->parent_id = $request->input('parent_id') ?? null;

		foreach ($this->langs as $lang) {
			$poll->{'title_' . $lang->key} = $request->input('store.title_' . $lang->key);
		}

		if ($poll->save()) {
			return [
				'success' => ['Опрос добавлен']
			];
		}

		return ['success' => ['Что-то пошло не так']];
	}

	public function show($id, $pollID)
	{
		$this->authorize('view', $this->section);

		$poll = Polls::where('section_id', $this->section->id)->where('id', $pollID)->first();

		$return = [];
		if (!is_null($poll)) {
			foreach ($this->langs as $lang) {
				$return['title_' . $lang->key] = $poll->{'title_' . $lang->key};
			}
		}

		return $return;
	}

	public function edit($id, $pollID)
	{
		$this->authorize('update', $this->section);

		return view('avl.settings.sections.polls.edit', [
			'section' => $this->section,
			'langs' => $this->langs,
			'pollID' => $pollID
		]);
	}

	public function update($id, $pollID, Request $request)
	{
		$this->authorize('update', $this->section);

		$poll = Polls::find($pollID);

		if (!is_null($poll)) {
			foreach ($this->langs as $lang) {
				$poll->{'title_' . $lang->key} = $request->input('store.title_' . $lang->key);
			}

			if ($poll->save()) {
				return [ 'success' => ['Опрос обновлен'] ];
			}
		}

		return ['success' => ['Опрос не найден']];
	}

	public function destroy($id, $pollID)
	{
		$poll = Polls::find($pollID);

		if (!is_null($poll)) {
			if ($poll->childrens()->count()) {
				$childrens = $poll->childrens()->get();
				if ($childrens->count() > 0) {
					foreach ($childrens as $children) {
						if ($children->childrens()->count() > 0) {
							$this->destroy($children->section_id, $children->id);
						}
						if ($children->votes()->count()) { \DB::table('poll-votes')->where('answer_id', $children->id)->delete(); }
						$children->delete();
					}
				}
			}

			if ($poll->votes()->count()) { \DB::table('poll-votes')->where('answer_id', $poll->id)->delete(); }
			$poll->delete();

			return ['success' => ['Запись удалена']];
		}

		return ['errors' => ['Опрос не найден']];
	}

	public function getRecords ($sectionID = null, $parent = null)
	{

		$polls = Polls::where('section_id', $sectionID);

		$polls = (is_null($parent)) ? $polls->whereNull('parent_id') : $polls->where('parent_id', $parent);
// dd($polls->orderBy('sind', 'ASC')->get());
		return $polls->withCount(['questions', 'votes'])->orderBy('sind', 'ASC')->get();
	}

}
