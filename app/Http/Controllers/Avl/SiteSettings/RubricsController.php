<?php namespace App\Http\Controllers\Avl\SiteSettings;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\{Sections, Langs, Rubrics};
use App\Traits\SectionsTrait;

class RubricsController extends AvlController
{

    protected $langs;

    public function __construct (Request $request)
    {
      parent::__construct($request);

      $this->langs = Langs::get();
    }

    public function lists ()
    {
      return view('avl.site_settings.rubrics.lists', [
        'sections' => SectionsTrait::tree(0, [], $this->userArea ?? 1)
      ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ($id)
    {
      $this->authorize('view', new Rubrics);

      $section = Sections::findOrFail($id);

      return view('avl.site_settings.rubrics.index', [
        'id' => $id,
        'langs' => $this->langs,
        'section' => $section,
        'rubrics' => $section->rubrics()->orderBy('published_at', 'DESC')->paginate(30)
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
      $this->authorize('create', new Rubrics);

      $section = Sections::findOrFail($id);

      return view('avl.site_settings.rubrics.create', [
        'langs' => $this->langs,
        'section' => $section
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
      $this->authorize('create', new Rubrics);

      $section = Sections::findOrFail($id);

      $post = $request->input();

      $this->validate(request(), [
        'button' => 'required|in:add,save',
        'rubric_published_at' => 'required|date_format:"Y-m-d"',
        'rubric_published_time' => 'required|date_format:"H:i"',
        'rubric_good_ru' => '',
        'rubric_title_ru' => 'max:255',
        'rubric_description_ru' => '',
      ]);

      $link = new Rubrics;

      foreach ($this->langs as $lang) {
        $good_lang = 'good_' . $lang->key;
        $title_lang = 'title_' . $lang->key;
        $description_lang = 'description_' . $lang->key;

        $link->$good_lang = $post['rubric_'.$good_lang];
        $link->$title_lang = $post['rubric_'.$title_lang];
        $link->$description_lang = $post['rubric_'.$description_lang];
      }

      $link->section_id = $id;
      $link->published_at = $post['rubric_published_at'] . ' ' . $post['rubric_published_time'];

      if ($link->save()) {
        if ($post['button'] == 'add') {
          return redirect()->route('admin.site.settings.rubrics.create', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
        }
        return redirect()->route('admin.site.settings.rubrics.index', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
      }

      return redirect()->route('admin.site.settings.rubrics.create', ['id' => $id])->with(['errors' => ['Что-то пошло не так.']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $rubric_id)
    {
      $this->authorize('update', new Rubrics);

      $section = Sections::findOrFail($id);

      return view('avl.site_settings.rubrics.edit', [
        'id' => $id,
        'section' => $section,
        'rubric' => $section->rubrics()->findOrFail($rubric_id),
        'langs' => $this->langs,
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $rubric_id)
    {
      $this->authorize('update', new Rubrics);

      $section = Sections::findOrFail($id);

      $post = $request->input();
      $this->validate(request(), [
        'button' => 'required|in:add,save',
        'rubric_published_at' => 'required|date_format:"Y-m-d"',
        'rubric_published_time' => 'required|date_format:"H:i"',
        'rubric_title_ru' => 'max:255',
        'rubric_description_ru' => '',
      ]);

      $rubric = Rubrics::findOrFail($rubric_id);

      foreach ($this->langs as $lang) {
        $good_lang = 'good_' . $lang->key;
        $title_lang = 'title_' . $lang->key;
        $link_lang = 'link_' . $lang->key;
        $description_lang = 'description_' . $lang->key;

        $rubric->$good_lang = $post['rubric_'.$good_lang];
        $rubric->$title_lang = $post['rubric_'.$title_lang];
        $rubric->$description_lang = $post['rubric_'.$description_lang];
      }

      $rubric->published_at = $post['rubric_published_at'] . ' ' . $post['rubric_published_time'];

      if ($rubric->save()) {
        return redirect()->route('admin.site.settings.rubrics.index', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
