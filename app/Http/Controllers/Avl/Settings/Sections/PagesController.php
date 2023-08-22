<?php

namespace App\Http\Controllers\Avl\Settings\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\{Sections, Pages, Langs};
use Cache;

class PagesController extends AvlController
{
    protected $langs = null;

    public function __construct (Request $request) {
      parent::__construct($request);

      $this->langs = Langs::get();
    }

    public function index($id)
    {
      $section = Sections::whereId($id)->where('area_id', $this->userArea)->firstOrFail();

      $this->authorize('update', $section);

      if (!$section->page) { $section->page()->save(new Pages()); }

      $section = Sections::whereId($id)->where('area_id', $this->userArea)->firstOrFail();

      return view('avl.settings.sections.pages.index', [
          'section' => $section,
          'images' => $section->page->images()->orderBy('sind', 'DESC')->get(),
          'langs' => $this->langs,
      ]);
    }

    public function update(Request $request, $id, $page_id = null)
    {
      $post = $request->input();
      $this->validate(request(), [
          'button' => 'required|in:add,save',
          'page_description_ru' => '',
      ]);

      $page = Pages::findOrFail($page_id);

      foreach ($this->langs as $lang) {
        $description = 'description_' . $lang->key;
        $page->$description = $post['page_'.$description] ?? null;

        // Параллельно очищаем кэш страниц
        if (Cache::has('page--' . $lang->key . '-' . $id)) {
          Cache::forget('page--' . $lang->key . '-' . $id);
        }

      }
      if ($page->save()) {
        return redirect()->back()->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
    }

}
