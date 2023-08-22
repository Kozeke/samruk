<?php namespace App\Http\Controllers\Avl\Settings\Configurations;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\{Sections, Langs, Configuration};

class SectionsController extends AvlController
{

  protected $langs = null;

  public function __construct (Request $request)
  {
    parent::__construct($request);

    $this->langs = Langs::get();
  }

  public function index ($id)
  {
    $section = Sections::findOrFail($id);

    if (is_null($section->configuration)) {
      // при первом входе создаем запись
      Configuration::updateOrCreate(
        ['section_id' => $id],
        [
          'section_id' => $id,
          'sidebar' => [
            "bastyk" => "1",
            "active-citizen" => "1",
            "dev-projects" => "1",
            "ref-numbers" => "1",
            "areas-city" => "1",
            "right-banners" => "1",
            "ikomek-ref-numbers" => "1",
            "population-figures" => "1"
          ]
      ]);
    }

    return view('avl.settings.sections.configurations.sections.index', [
      'section' => Sections::findOrFail($id),
      'langs' => $this->langs
    ]);
  }

  public function save ($id, Request $request)
  {

    $post = $this->validate(request(), [
      "name_ru" => "",
      "keywords_ru" => "",
      "description_ru" => "",
      "name_en" => "",
      "keywords_en" => "",
      "description_en" => "",
      "name_kz" => "",
      "keywords_kz" => "",
      "description_kz" => "",
      "sidebar" => ""
    ]);
    if (!isset($post['sidebar'])) {
      $post = array_add($post, 'sidebar', null);
    }
    $post = array_add($post, 'section_id', $id);
    // dd($post);
    Configuration::updateOrCreate   (
      ['section_id' => $id],
      $post
    );

    return redirect()->back();
  }
}
