<?php

namespace App\Http\Controllers\Avl\Settings\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\{Sections, Langs, Links};
use Cache;

class LinksController extends AvlController
{

  protected $langs = null;

  public function __construct (Request $request) {
    parent::__construct($request);

    $this->langs = Langs::get();
  }

  public function index($id)
  {
    $section = Sections::find($id);
    $links = Links::where('section_id', $id)->orderBy('published_at', 'DESC');

    return view('avl.settings.sections.links.index', [
      'langs' => $this->langs,
      'links' => $links->paginate(20),
      'section' => $section,
      'id' => $id
    ]);
  }

  public function create($id)
  {
    return view('avl.settings.sections.links.create', [
      'langs' => $this->langs,
      'id' => $id
    ]);
  }

  public function store(Request $request, $id)
  {
    $post = $request->input();

    $this->validate(request(), [
      'button' => 'required|in:add,save',
      'links_published_at' => 'required|date_format:"Y-m-d"',
      'links_published_time' => 'required|date_format:"H:i"',
      'links_class' => '',
      'links_title_ru' => '',
      'links_link_ru' => 'required',
      'links_description_ru' => '',
      'links_appstore' => '',
      'links_market' => '',
    ]);

    $links = new Links;

    foreach ($this->langs as $lang) {
      $links->{'good_' . $lang->key}        = $post['links_good_' . $lang->key];
      $links->{'title_' . $lang->key}       = $post['links_title_' . $lang->key];
      $links->{'link_' . $lang->key}        = $post['links_link_' . $lang->key];
      $links->{'description_' . $lang->key} = $post['links_description_' . $lang->key];
    }

    $links->published_at = $post['links_published_at'] . ' ' . $post['links_published_time'];
    $links->class = $post['links_class'];
    $links->appstore = $post['links_appstore'];
    $links->market = $post['links_market'];
    $links->section_id = $id;

    if ($links->save()) {
      if ($post['button'] == 'save') {
        return redirect()->route('links.create', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->route('links.index', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
    }

    return redirect()->route('links.create', ['id' => $id])->with(['errors' => ['Что-то пошло не так.']]);
  }

  public function edit($id, $link_id)
  {
    $link = Links::findOrFail($link_id);

    return view('avl.settings.sections.links.edit', [
      'section' => Sections::find($id),
      'id' => $id,
      'langs' => $this->langs,
      'link' => $link,
    ]);
  }

  public function show($id, $link_id)
  {
    $link = Links::findOrFail($link_id);

    return view('avl.settings.sections.links.show', [
      'section' => Sections::find($id),
      'id' => $id,
      'langs' => $this->langs,
      'link' => $link,
    ]);
  }

  public function update(Request $request, $id, $link_id)
  {
    $section = Sections::findOrFail($id);

    $data = $request->input();
    $this->validate(request(), [
      'button' => 'required|in:add,save',
      'links_published_at' => 'required|date_format:"Y-m-d"',
      'links_published_time' => 'required|date_format:"H:i"',
      'links_class' => '',
      'links_title_ru' => '',
      'links_link_ru' => 'required',
      'links_description_ru' => '',
      'links_appstore' => '',
      'links_market' => '',
    ]);

    $links = Links::findOrFail($link_id);

    foreach ($this->langs as $lang) {
      $links->{'good_' . $lang->key}        = $data['links_good_' . $lang->key];
      $links->{'title_' . $lang->key}       = $data['links_title_' . $lang->key];
      $links->{'link_' . $lang->key}        = $data['links_link_' . $lang->key];
      $links->{'description_' . $lang->key} = $data['links_description_' . $lang->key];

      // Очищаем файлы кеша
      if (Cache::has('col-links-' . $lang->key . '-' . $section->alias)) {
        Cache::forget('col-links-' . $lang->key . '-' . $section->alias);
      }
    }

    $links->published_at = $data['links_published_at'] . ' ' . $data['links_published_time'];
    $links->class = $data['links_class'];
    $links->appstore = $data['links_appstore'];
    $links->market = $data['links_market'];

    if ($links->save()) {
      return redirect()->route('links.index', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
    }
    return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
  }

  public function destroy($id)
  {
    //
  }
}
