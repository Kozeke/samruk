<?php namespace App\Http\Controllers\Site\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\Sections\SectionsController;
use App\Models\{Sections, Objects};
use Carbon\Carbon;
use Cache;
use View;

class ObjectsController extends SectionsController
{

	public function index (Request $request)
	{
			$template = 'site.templates.objects.short.' . $this->getTemplateFileName($this->section->current_template->file_short) ?? 'default' ;

			$records = $this->section->objects();

			$records = $this->getQuery($records, $request);

			$template = (View::exists($template)) ? $template : 'site.templates.objects.short.default';

			$records = $records->orderBy('published_at', 'DESC')->paginate($this->section->current_template->records ?? 10);

			$rubrics = $this->section ? $this->section->rubrics()->good()->orderBy('published_at', 'DESC')->get() : null;

			return view($template, [
					'records' => $records,
					'pagination' => $records->appends($_GET)->links(),
					'request' => $request,
					'rubrics' => $this->prepareArray($rubrics)
			]);
	}

	public function show(Request $request)
	{
			$template = 'site.templates.objects.full.' . $this->getTemplateFileName($this->section->current_template->file_full);

			$object = $this->section->objects()->where('good_' . $this->lang, 1)->findOrFail($request->object);

			$object->timestamps = false;  // отключаем обновление даты
			$object->increment('view');   // увеличиваем кол-во просмотров этой записи

			$template = (View::exists($template)) ? $template : 'site.templates.objects.full.default';

			return view($template, [
				'object' => $object,
				'full' => true
			]);
	}

	public function getQuery ($query, $request)
	{

		// фильтр если приходит
		if ($request->input('rubric') && $request->input('rubric') > 0) {
			$query = $query->where('rubric_id', $request->input('rubric'))->whereHas('rubric', function ($query) {
				$query->where('good_' . $this->lang, 1);
			});
		}

		if ($request->input('type')) {
			$query = $query->where('type', $request->input('type'));
		}

		if ($request->input('program')) {
			$query = $query->where('program', $request->input('program'));
		}

		$query = $query->where('good_' . $this->lang, 1);

		return $query;
	}

	public function prepareArray ($records = [])
	{
		$return = [];
		if ($records->count() > 0) {
			foreach ($records as $record) {
				$return[$record->id] = $record->{'title_' . $this->lang} ?? $record->title_ru;
			}
		}
		return $return;
	}
}
