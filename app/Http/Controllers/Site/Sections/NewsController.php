<?php namespace App\Http\Controllers\Site\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\Sections\SectionsController;
use App\Models\{Sections, News};
use Carbon\Carbon;
use Cache;
use View;

class NewsController extends SectionsController
{

	public function index (Request $request)
	{
		if ((is_null($this->section->rubric) || $this->section->rubric == 0) || $this->section->alias == 'news') {

			$template = 'site.templates.news.short.' . $this->getTemplateFileName($this->section->current_template->file_short);

			$records = $this->section->news();
			// ->orWhereHas('sections', function ($query) {
			// 		$query->where('good_' . $this->lang, 1);
			// });

			$records = $this->getQuery($records, $request);

			$records = $records->orderBy('published_at', 'DESC')->paginate($this->section->current_template->records);

			$template = (View::exists($template)) ? $template : 'site.templates.news.short.default';

			return view($template, [
					'records' => $records,
					'rubrics' => $this->section->rubrics()->where('good_' . $this->lang, 1)->orderBy('title_ru', 'ASC')->get(),
					'pagination' => $records->appends($_GET)->links(),
					'request' => $request
			]);
		}

		return redirect()->route('site.news.rubrics', ['alias' => $this->section->alias]);
	}

	public function show(Request $request)
	{
			$template = 'site.templates.news.full.' . $this->getTemplateFileName($this->section->current_template->file_full);

			$data = News::where('good_' . $this->lang, 1)->findOrFail($request->id);

			$data->timestamps = false;  // отключаем обновление даты
			$data->increment('view');   // увеличиваем кол-во просмотров этой записи

			$template = (View::exists($template)) ? $template : 'site.templates.news.full.default';

			return view($template, [
				'data' => $data,
				'images' => $data->media()->where('good', 1)->where('switch_' . $this->lang, true)->orderBy('main', 'DESC')->orderBy('sind', 'DESC')->get(),
				'files' => $data->media('file')->where('lang', $this->lang)->where('good', 1)->orderBy('sind', 'DESC')->get(),
				'videos' => $data->media('video')->where('lang', $this->lang)->where('good', 1)->orderBy('sind', 'DESC')->get(),
				'relatedsNews' => $this->getRelatedNews($request->alias, $request->id, $data->rubric_id),
				'fullNews' => true
			]);
	}

	public function rubrics (Request $request)
	{
		$records = $this->section->rubrics()->where('good_' . $this->lang, 1)->orderBy('published_at', 'DESC');

		$template = 'site.templates.news.category.' . $this->getTemplateFileName($this->section->current_template->file_category);

		$records = $records->paginate($this->section->current_template->records);

		return view($template, [
			'records' => $records,
			'pagination' => $records->appends($_GET)->links(),
			'byPage' => $this->section->current_template->records
		]);
	}

	public function rubricsShow (Request $request)
	{
		$template = 'site.templates.news.short.' . $this->getTemplateFileName($this->section->current_template->file_short);

		$records = $this->getQuery($this->section->news(), $request);

		$records = $records->where('rubric_id', $request->rubric)->orderBy('published_at', 'DESC')->paginate($this->section->current_template->records);

		return view($template, [
				'records' => $records,
				'rubrics' => $this->section->rubrics()->orderBy('published_at', 'desc')->get(),
				'rubricOne' => $this->section->rubrics()->find($request->rubric),
				'pagination' => $records->appends($_GET)->links(),
				'request' => $request
		]);
	}

	public function getQuery ($result, $request)
	{

		$result = $result->where('good_' . $this->lang, 1);

		// фильтр если приходит
		if ($request->input('rubric') && $request->input('rubric') > 0) {
			$result = $result->where('rubric_id', $request->input('rubric'))->whereHas('rubric', function ($query) {
				$query->where('good_' . $this->lang, 1);
			});
		}

		if ($request->input('from') && $request->input('before')) {
			$result = $result->whereBetween('published_at', [$request->input('from'), $request->input('before')]);
		}

		$result = $result->with(['media' => function($query) {
			$query->where('good', 1)->orderBy('main', 'DESC')->orderBy('sind', 'DESC');
		}, 'rubric']);

		$result = $result->where('published_at', '<=', Carbon::now());

		return $result;
	}

	public function getRelatedNews ($alias, $id, $rubric_id = null)
	{
			// $relateds = $this->section->news()->where('good_' . $this->lang, 1);
			//
			// // если у этой новости есть рубрика то выбираем новости только из этой рубрики
			// if (!is_null($rubric_id)) { $relateds = $relateds->where('rubric_id', $rubric_id); }
			//
			// $relateds = $relateds->whereNotNull('title_' . $this->lang)
			// 									->where('id', '!=', $id)
			// 									->orderBy('published_at', 'DESC')
			// 									->limit(5)
			// 									->get();
			//
			// return view('site.blocks.snippets.relateds-news', [
			// 	'relatedsNews' => $relateds
			// ])->render();
	}

}
