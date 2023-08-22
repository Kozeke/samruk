<?php namespace App\Http\Controllers\Avl\Settings\Sections;

use App\Http\Controllers\Avl\AvlController;
use App\Models\{
	Media, Objects, Langs, Sections
};
use Carbon\Carbon;
use Illuminate\Http\Request;
use File;

class ObjectsController extends AvlController
{
	protected $langs = null;

	protected $section;

	protected $rubrics = [];

	public function __construct (Request $request) {
		parent::__construct($request);

		$this->langs = Langs::get();

		$this->section = Sections::find($request->id) ?? null;

		$rubrics = $this->section ? $this->section->rubrics()->select('id', 'title_ru')->get()->toArray() : [];

		$this->rubrics = array_add(toSelectTransform($rubrics), 0, 'Объекты без рубрики');
	}

	public function index($id, Request $request)
	{
		$this->authorize('view', $this->section);

		$objects = Objects::where('section_id', $this->section->id);

		$objects = $this->getQuery($objects, $request);

		return view('avl.settings.sections.objects.index', [
			'id' => $id,
			'section' => $this->section,
			'request' => $request,
			'langs' => $this->langs,
			'objects' => $objects->orderBy('published_at', 'DESC')->paginate(30),
			'rubrics' => $this->rubrics,
		]);
	}

	public function create($id)
	{
		$this->authorize('create', $this->section);

		unset ($this->rubrics[0]);

		return view('avl.settings.sections.objects.create', [
			'langs' => $this->langs,
			'section' => $this->section,
			'rubrics' => $this->rubrics,
		]);
	}

	public function store(Request $request, $id)
	{
		$this->authorize('create', $this->section);

		$post = $request->input();

		$this->validate(request(), [
			'button' => 'required|in:add,save,edit',
			'rubric_id' => 'sometimes',
			'program' => 'sometimes',
			'type' => 'required',
			'title_ru' => 'max:500',
			'published_at' => 'required|date_format:"Y-m-d"',
			'published_time' => 'required|date_format:"H:i"'
		], [
			'type.required' => '<b>Тип объекта</b> не указан',
			'published_at.required' => '<b>Дата публикации</b> не указана',
			'published_time.required' => '<b>Время публикации</b> не указано',
			'published_at.date_format' => '<b>Дата публикации</b> формат не верно указан',
			'published_time.date_format' => '<b>Время публикации</b> формат не верно указан',
		]);

		// Удаляем все лишнее из массива на вставку новой записи
		unset ( $post['button'], $post['_token'], $post['published_time'], $post['published_at'] );

		$data = \array_merge ($post, [
				'section_id' => $this->section->id,
				'published_at' => $request->input('published_at') . ' ' . $request->input('published_time'),
		]);

		if ($object = Objects::create($data)) {
			if ($request->input('button') == 'add') {
				return redirect()->route('admin.settings.sections.objects.create', ['id' => $this->section->id])->with(['success' => ['Сохранение прошло успешно!']]);
			}
			if ($request->input('button') == 'edit') {
				return redirect()->route('admin.settings.sections.objects.edit', ['id' => $this->section->id, 'object' => $object->id])->with(['success' => ['Сохранение прошло успешно!']]);
			}
			return redirect()->route('admin.settings.sections.objects.index', ['id' => $this->section->id])->with(['success' => ['Сохранение прошло успешно!']]);
		}

		return redirect()->route('admin.settings.sections.objects.create', ['id' => $this->section->id])->withInput()->with(['errors' => ['Что-то пошло не так.']]);
	}

	public function show($id, $news_id)
	{
		$this->authorize('view', Sections::findOrFail($id));

		return view('avl.settings.sections.news.show', [
			'langs' => $this->langs,
			'new' => News::findOrFail($news_id),
			'id' => $id
		]);
	}

	public function edit($id, $object)
	{
		$this->authorize('update', $this->section);

		unset ($this->rubrics[0]);

		return view('avl.settings.sections.objects.edit', [
			'object' => Objects::where('section_id', $this->section->id)->where('id', $object)->first(),
			'section' => $this->section,
			'rubrics' => $this->rubrics,
			'langs' => $this->langs,
		]);
	}

	public function update(Request $request, $id, $objectID)
	{
		$this->authorize('update', $this->section);

		$post = $request->input();

		$this->validate(request(), [
			'button' => 'required|in:save',
			'rubric_id' => 'sometimes',
			'program' => 'sometimes',
			'type' => 'required',
			'title_ru' => 'max:500',
			'published_at' => 'required|date_format:"Y-m-d"',
			'published_time' => 'required|date_format:"H:i"'
		], [
			'type.required' => '<b>Тип объекта</b> не указан',
			'published_at.required' => '<b>Дата публикации</b> не указана',
			'published_time.required' => '<b>Время публикации</b> не указано',
			'published_at.date_format' => '<b>Дата публикации</b> формат не верно указан',
			'published_time.date_format' => '<b>Время публикации</b> формат не верно указан',
		]);

		$object = Objects::findOrFail($objectID);

		// Удаляем все лишнее из массива на вставку новой записи
		unset (
			$post['button'],
			$post['_token'],
			$post['published_time'],
			$post['published_at'],
			$post['object_id'],
			$post['upload'],
			$post['news_video_title'],
			$post['news_video_link']
		);

		$data = \array_merge ($post, [
				'section_id' => $this->section->id,
				'published_at' => $request->input('published_at') . ' ' . $request->input('published_time'),
		]);

		if ($object->update($data)) {
			return redirect()->route('admin.settings.sections.objects.index', ['id' => $this->section->id])->with(['success' => ['Сохранение прошло успешно!']]);
		}

		return redirect()->route('admin.settings.sections.objects.edit', ['id' => $this->section->id, 'object' => $object->id])->withInput()->with(['errors' => ['Что-то пошло не так.']]);
	}

	public function destroy($id, $objectID)
	{
		$this->authorize('delete', $this->section);

		$data = Objects::find($objectID);
		if (!is_null($data)) {

			if ($data->media('image')->count() > 0) {
				foreach ($data->media('image')->get() as $image) {
					if (File::exists(public_path($image->link))) {
						$fileName = last(explode('/', $image->link));

						array_map("unlink", glob(public_path('data/media/objects/images/_thumbs/thumb_*-' . $fileName)));

						File::delete(public_path($image->link));
					}
					$image->delete();
				}
			}

			if ($data->media('file')->count() > 0) {
				foreach ($data->media('file')->get() as $file) {
					if (File::exists(public_path($file->link))) {
						File::delete(public_path($file->link));
					}
					$file->delete();
				}
			}
			if ($data->delete()) {
				return ['success' => ['Новость удалена']];
			}
		}

		return ['errors' => ['Ошибка удаления.']];
	}

	public function getQuery ($query, $request)
	{
		if (!is_null($request->input('rubric'))) {
			if ($request->input('rubric') == 0) {
				$query = $query->whereNull('rubric_id');
			} else {
				$query = $query->where('rubric_id', $request->input('rubric'));
			}
		}

		if (!is_null($request->input('type'))) {
			$query = $query->where('type', $request->input('type'));
		}

		if (!is_null($request->input('program'))) {
			$query = $query->where('program', $request->input('program'));
		}

		return $query;
	}

}
