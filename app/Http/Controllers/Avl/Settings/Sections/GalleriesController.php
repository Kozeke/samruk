<?php namespace App\Http\Controllers\Avl\Settings\Sections;

use App\Http\Controllers\Avl\AvlController;
use App\Models\{
  Media, Langs, Galleries, Sections
};
use App\Traits\SectionsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cache;
use Auth;
use File;

class GalleriesController extends AvlController
{
  protected $langs = null;

  public function __construct (Request $request) {
    parent::__construct($request);

    $this->langs = Langs::get();
  }

  public function index($id)
  {
    $this->authorize('view', new Sections);

    $section = Sections::find($id);
    $galleries = Galleries::where('section_id', $id)->orderBy('published_at', 'DESC');

    return view('avl.settings.sections.galleries.index', [
      'langs' => $this->langs,
      'galleries' => $galleries->paginate(30),
      'section' => $section
    ]);
  }

  public function create($id)
  {
    $this->authorize('create', new Sections);

    $section = Sections::find($id);

    return view('avl.settings.sections.galleries.create', [
      'langs' => $this->langs,
      'section' => $section
    ]);
  }

  public function store(Request $request, $id)
  {
    $this->authorize('create', new Sections);
    $post = $request->input();

    $this->validate(request(), [
      'button' => 'required|in:add,save,edit',
      'gallery_title_ru' => 'max:255',
      'gallery_description_ru' => '',
      'gallery_published_at' => 'required|date_format:"Y-m-d"',
      'gallery_published_time' => 'required|date_format:"H:i"',
      'gallery_class' => 'max:255'
    ]);

    $gallery = new Galleries;

    foreach ($this->langs as $lang) {
      $gallery->{'good_' . $lang->key} = $post['gallery_good_' . $lang->key];
      $gallery->{'title_' . $lang->key} = $post['gallery_title_' . $lang->key];
      $gallery->{'description_' . $lang->key} = $post['gallery_description_' . $lang->key];
    }

    $gallery->published_at = $post['gallery_published_at'] . ' ' . $post['gallery_published_time'];
    $gallery->class = $post['gallery_class'];
    $gallery->section_id = $id;
    $gallery->created_user = Auth::user()->id;

    if ($gallery->save()) {
      if ($post['button'] == 'add') {
        return redirect()->route('admin.settings.sections.gallery.create', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
      }
      if ($post['button'] == 'edit') {
        return redirect()->route('admin.settings.sections.gallery.edit', ['id' => $id, 'gallery' => $gallery->id])->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->route('admin.settings.sections.gallery.index', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
    }

    return redirect()->route('admin.settings.sections.gallery.create', ['id' => $id])->with(['errors' => ['Что-то пошло не так.']]);
  }

  public function show($id, $gallery)
  {
    $this->authorize('view', new Sections);

    return view('avl.settings.sections.galleries.show', [
      'langs' => $this->langs,
      'gallery' => Galleries::findOrFail($gallery),
      'section' => Sections::findOrFail($id)
    ]);
  }

  public function edit($id, $gallery_id)
  {
    $this->authorize('update', new Sections);

    $gallery = Galleries::whereSectionId($id)->whereId($gallery_id)->firstOrFail();

    return view('avl.settings.sections.galleries.edit', [
      'section' => Sections::findOrFail($id),
      'langs' => $this->langs,
      'gallery' => $gallery,
      'images' => $gallery->images()->orderBy('sind', 'DESC')->get(),
      'videos' => $gallery->videos()->orderBy('created_at', 'DESC')->get(),
    ]);
  }

  public function update($id, $gallery_id, Request $request)
  {
    $this->authorize('update', new Sections);

    $post = $request->input();

    $this->validate(request(), [
      'button' => 'required|in:add,save',
      'gallery_title_ru' => 'max:255',
      'gallery_description_ru' => '',
      'gallery_published_at' => 'required|date_format:"Y-m-d"',
      'gallery_published_time' => 'required|date_format:"H:i"',
      'gallery_class' => 'max:255'
    ]);

    $gallery = Galleries::findOrFail($gallery_id);

    foreach ($this->langs as $lang) {
      $gallery->{'good_' . $lang->key} = $post['gallery_good_' . $lang->key];
      $gallery->{'title_' . $lang->key} = $post['gallery_title_' . $lang->key];
      $gallery->{'description_' . $lang->key} = $post['gallery_description_' . $lang->key];

      // Параллельно очищаем кэш страницы альбома
      if (Cache::has('gallery-' . $lang->key . '-' . $id)) {
        Cache::forget('gallery-' . $lang->key . '-' . $id);
      }
    }

    $gallery->published_at = $post['gallery_published_at'] . ' ' . $post['gallery_published_time'];
    $gallery->class = $post['gallery_class'];
    $gallery->update_user = Auth::user()->id;

    if ($gallery->save()) {
      if ($post['button'] == 'add') {
        return redirect()->route('admin.settings.sections.gallery.edit', ['id' => $id, '' => $gallery_id])->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->route('admin.settings.sections.gallery.index', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
    }

    return redirect()->route('admin.settings.sections.gallery.edit', ['id' => $id, '' => $gallery_id])->with(['errors' => ['Что-то пошло не так.']]);
  }

  public function destroy($id, $gallery_id)
  {
    // $this->authorize('delete', new Galleries);
    //
    // $gallery = Galleries::find($gallery_id);
    // if (!is_null($gallery)) {
    //
    //   if ($gallery->images()->count() > 0) {
    //     foreach ($gallery->images()->get() as $image) {
    //       if (File::exists(public_path($image->link))) {
    //         $fileName = last(explode('/', $image->link));
    //
    //         array_map("unlink", glob(public_path('data/media/gallery/_thumbs/thumb_*-' . $fileName)));
    //
    //         File::delete(public_path($image->link));
    //       }
    //       $image->delete();
    //     }
    //   }
    //
    //   if ($gallery->videos()->count() > 0) {
    //     $gallery->videos()->delete();
    //   }
    //
    //   if ($gallery->delete()) {
    //     return ['success' => ['Альбом <b>'.$gallery->title_ru.'</b> удалена']];
    //   }
    // }
    //
    // return ['errors' => ['Ошибка удаления.']];
  }
}
