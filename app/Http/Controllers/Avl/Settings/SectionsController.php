<?php namespace App\Http\Controllers\Avl\Settings;

use App\Http\Controllers\Avl\AvlController;
use App\Models\{Sections, Langs, Menu};
use Illuminate\Validation\Rule;
use App\Traits\SectionsTrait;
use Illuminate\Http\Request;
use View;

class SectionsController extends AvlController
{

    protected $accessModel = null;

    public function __construct (Request $request) {
      parent::__construct($request);

			$this->accessModel = Menu::where('model', 'App\Models\Sections')->first();

      View::share('accessModel', $this->accessModel);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $this->authorize('view', $this->accessModel);

      return view('avl.settings.sections.index', [
          'sections' => SectionsTrait::tree(0, [], $this->userArea),
          'langs' => Langs::where('key', '!=', 'ru')->get()
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', $this->accessModel);

      return view('avl.settings.sections.create',[
        'sections' => SectionsTrait::tree(0, [], $this->userArea),
        'langs' => Langs::get(),
        'templates' => \App\Models\Templates::where('template', 'page')->get()
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', $this->accessModel);

      $post = $this->validate(request(), [
          'button' => 'required|in:add,save',
          'section_name_ru' => 'required|min:2|max:255',
          'section_type' => 'required|min:1',
          'section_template' => 'required',
          'section_good' => 'numeric',
          'section_menu' => 'numeric',
          'section_rubric' => 'numeric',
          'section_parent' => 'required',
          'section_alias' => [
            'required',
            'min:2',
            Rule::unique('sections', 'alias')->where(function ($query) {
              $query->where('area_id', $this->userArea);
            })
          ],
          'section_classes' => 'max:255'
      ]);

      $section = new Sections;
      $langs = Langs::get();

      $name = $request->input();
      foreach ($langs as $lang) {
        $name_lang = 'name_' . $lang->key;
        if (isset($name['section_'.$name_lang])) {
            $section->$name_lang = $name['section_'.$name_lang];
        }
      }

      $section->type = $post['section_type'];
      $section->template = $post['section_template'];
      $section->good = $post['section_good'];
      $section->menu = $post['section_menu'];
      $section->rubric = $post['section_rubric'];
      $section->parent_id = $post['section_parent'];
      $section->alias = $post['section_alias'];
      $section->classes = $post['section_classes'];
      $section->area_id = $this->userArea;

      if ($section->save()) {
        if ($post['button'] == 'add') {
            return redirect()->route('admin.settings.sections.create')->with(['success' => ['Сохранение прошло успешно!']]);
        }
        return redirect()->route('admin.settings.sections.index')->with(['success' => ['Сохранение прошло успешно!']]);
      }

      return redirect()->route('admin.settings.sections.create')->with(['errors' => ['Что-то пошло не так.']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $this->authorize('view', $this->accessModel);

      return view('avl.settings.sections.show', [
          'section' => Sections::findOrFail($id)
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $this->authorize('update', $this->accessModel);
      $section = Sections::find($id);

      return view('avl.settings.sections.edit', [
          'section' => $section,
          'sections' => SectionsTrait::tree(0, [], $this->userArea),
          'templates' => $section->templates()->get(),
          'langs' => Langs::get()
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->authorize('update', $this->accessModel);

      $post = $this->validate(request(), [
          'button' => 'required|in:add,save',
          'section_name_ru' => 'required|min:2|max:255',
          'section_type' => 'required|min:1',
          'section_template' => 'required',
          'section_good' => 'numeric',
          'section_menu' => 'numeric',
          'section_rubric' => 'numeric',
          'section_parent' => 'required',
          'section_submenu' => 'boolean',
          'section_alias' => [
            'required',
            'min:2',
            Rule::unique('sections', 'alias')->where(function ($query) {
              $query->where('area_id', $this->userArea);
            })->ignore($id)
          ],
          'section_classes' => 'max:255'
      ]);

      $section = Sections::findOrFail($id);
      $langs = Langs::get();

      $name = $request->input();
      if ($section) {
        foreach ($langs as $lang ) {
          $name_lang = 'name_' . $lang->key;
          if (isset($name['section_name_'.$lang->key])) {
            $section->$name_lang = $name['section_'.$name_lang];
          }
        }
        $section->type = $post['section_type'];
        $section->template = $post['section_template'];
        $section->good = $post['section_good'];
        $section->menu = $post['section_menu'];
        $section->rubric = $post['section_rubric'];
        $section->parent_id = $post['section_parent'];
        $section->submenu = $post['section_submenu'] ?? false;
        $section->alias = $post['section_alias'];
        $section->classes = $post['section_classes'];

        $section->save();

        return redirect()->route('admin.settings.sections.index')->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->route('admin.settings.sections.edit', ['section' => $id])->with(['errors' => ['Что-то пошло не так.']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $section = Sections::with(['children'])->find($id);

      if (!is_null($section)) {
        if ($section->children->count() > 0) {

        }
      }

      return ['errors' => ['Произошла ошибка удаления.']];
    }


}
