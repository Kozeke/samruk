<?php namespace App\Http\Controllers\Avl\Settings\Sections;

use App\Http\Controllers\Avl\AvlController;
use App\Models\{
  Media, News, Langs, Rubrics, Sections
};
use App\Traits\SectionsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cache;
use Auth;
use File;

class NewsController extends AvlController
{
  protected $langs = null;

  public function __construct (Request $request) {
    parent::__construct($request);

    $this->langs = Langs::get();
  }

  public function index($id, Request $request)
  {
    $section = Sections::whereId($id)->where('area_id', $this->userArea)->firstOrFail();

    $this->authorize('view', $section);

    // Запоминаем номер страницы на которой находимся
    $request->session()->put('page', $request->input('page') ?? 1);

    $news = $section->news();

    if (!is_null($request->input('rubric'))) {
      if ($request->input('rubric') == 0) {
        $news = $news->whereNull('rubric_id');
      } else {
        $news = $news->where('rubric_id', $request->input('rubric'));
      }
    }

    $news = $news->orderBy('published_at', 'DESC');

    return view('avl.settings.sections.news.index', [
      'id' => $id,
      'section' => $section,
      'request' => $request,
      'langs' => $this->langs,
      'news' => $news->paginate(30),
      'rubrics' => array_add(toSelectTransform(Rubrics::select('id', 'title_ru')->where('section_id', $section->id)->get()->toArray()), 0, 'Новости без рубрики'),
    ]);
  }

  public function create($id)
  {
    $section = Sections::whereId($id)->where('area_id', $this->userArea)->firstOrFail();

    $this->authorize('create', $section);

    return view('avl.settings.sections.news.create', [
      'langs' => $this->langs,
      'section' => $section,
      'rubrics' => $section->rubrics()->orderBy('published_at', 'DESC')->get(),
      'id' => $id
    ]);
  }

  public function store(Request $request, $id)
  {
    $this->authorize('create', Sections::findOrFail($id));

    $post = $request->input();

    $this->validate(request(), [
      'button' => 'required|in:add,save,edit',
      'news_rubric_id' => 'sometimes',
      'news_short_ru' => '',
      'news_full_ru' => '',
      'news_title_ru' => 'max:255',
      'news_published_at' => 'required|date_format:"Y-m-d"',
      'news_published_time' => 'required|date_format:"H:i"'
    ]);

    $news = new News;

    foreach ($this->langs as $lang) {
      $good_lang = 'good_' . $lang->key;
      $title_lang = 'title_' . $lang->key;
      $short_lang = 'short_' . $lang->key;
      $full_lang = 'full_' . $lang->key;

      $news->$good_lang = $post['news_'.$good_lang];
      $news->$title_lang = $post['news_'.$title_lang];
      $news->$short_lang = $post['news_'.$short_lang];
      $news->$full_lang = $post['news_'.$full_lang];
    }

    $news->published_at = $post['news_published_at'] . ' ' . $post['news_published_time'];
    $news->section_id = $id;
    if (isset($post['news_rubric_id']) && ($post['news_rubric_id'] > 0)) { $news->rubric_id = $post['news_rubric_id']; }   // проставляему рубрику если ее выбрали
    $news->created_user = Auth::user()->id;

    $news->save();
    if ($news) {
      if ($post['button'] == 'add') {
        return redirect()->route('news.create', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
      }
      if ($post['button'] == 'edit') {
        return redirect()->route('news.edit', ['id' => $id, 'news_id' => $news->id])->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->route('news.index', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
    }

    return redirect()->route('news.create', ['id' => $id])->with(['errors' => ['Что-то пошло не так.']]);
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

  public function edit($id, $news_id)
  {
    $section = Sections::whereId($id)->where('area_id', $this->userArea)->firstOrFail();

    $this->authorize('update', $section);

    $news = $section->news()->findOrFail($news_id);

    return view('avl.settings.sections.news.edit', [
      'new' => $news,
      'id' => $id,
      'section' => $section,
      'rubrics' => $section->rubrics()->orderBy('published_at', 'DESC')->get(),
      'images' => $news->media('image')->orderBy('sind', 'DESC')->get(),
      'files' => $news->media('file')->orderBy('sind', 'DESC')->get(),
      'videos' => $news->media('video')->orderBy('created_at', 'DESC')->get(),
      'langs' => $this->langs,
    ]);
  }

  public function update(Request $request, $id, $news_id)
  {
    $this->authorize('update', Sections::findOrFail($id));

    $post = $request->input();

    $this->validate(request(), [
      'button' => 'required|in:add,save',
      'news_rubric_id' => 'sometimes',
      'news_title_ru' => 'max:255',
      'news_short_ru' => '',
      'news_full_ru' => '',
      'news_published_at' => 'required|date_format:"Y-m-d"',
      'news_published_time' => 'required|date_format:"H:i"'
    ]);

    $news = News::findOrFail($news_id);

    foreach ($this->langs as $lang) {
      $good_lang  = 'good_' . $lang->key;
      $title_lang = 'title_' . $lang->key;
      $short_lang = 'short_' . $lang->key;
      $full_lang  = 'full_' . $lang->key;

      $news->$good_lang = $post['news_'.$good_lang];
      $news->$title_lang = $post['news_'.$title_lang];
      $news->$short_lang = $post['news_'.$short_lang];
      $news->$full_lang = $post['news_'.$full_lang];

			$news->sections()->detach();
			if (isset($post['sections']) && (count($post['sections']) > 0)) {
				foreach ($post['sections'] as $area => $sections) {
					if (isset($sections[0]) && ($sections[0] > 0)) {
						$news->sections()->attach($sections, ['area_id' => $area]);
					}
				}
			}

      // Параллельно очищаем кэш страниц
      if (Cache::has('full-news-' . $lang->key . '-' . $id)) {
        Cache::forget('full-news-' . $lang->key . '-' . $id);
      }
    }

    $news->published_at = $post['news_published_at'] . ' ' . $post['news_published_time'];

    if (isset($post['news_rubric_id']) && ($post['news_rubric_id'] > 0)) {
      $news->rubric_id = $post['news_rubric_id'];
    } else {
      $news->rubric_id = null;
    }

    $news->update_user =  Auth::user()->id;

    if ($news->save()) {
      return redirect()->route('news.index', ['id' => $id, 'page' => $request->session()->get('page', '1') ])
                       ->with(['success' => ['Сохранение прошло успешно!']]);
    }
    return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
  }

  public function move ($id, $news_id, Request $request)
  {
    $this->authorize('update', Sections::findOrFail($id));

    return view('avl.settings.sections.news.move', [
      'new' => News::findOrFail($news_id),
      'id' => $id
    ]);
  }

  public function moveSave ($id, $news_id, Request $request)
  {
    $this->authorize('update', Sections::findOrFail($id));

    $this->validate($request, [
      'new_section' => 'required|exists:sections,id,type,news'
    ]);

    if ($request->input('new_section') > 0) {

      $data = News::findOrFail($news_id);

      $data->section_id = $request->input('new_section');

      if ($data->save()) {
        return redirect()->route('news.index', ['id' => $id]);
      }
    }
    return redirect()->back()->with(['errors' => ['Выберите раздел']]);
  }

  public function destroy($id, $news_id)
  {
    $this->authorize('delete', Sections::findOrFail($id));

    $data = News::find($news_id);
    if (!is_null($data)) {

      if ($data->media('image')->count() > 0) {
        foreach ($data->media('image')->get() as $image) {
          if (File::exists(public_path($image->link))) {
            $fileName = last(explode('/', $image->link));

            array_map("unlink", glob(public_path('data/media/news/images/_thumbs/thumb_*-' . $fileName)));

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

}
