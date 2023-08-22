<?php namespace App\Http\Controllers\Avl\Settings\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\{News, Langs, Sections, Services};
use Auth;
use File;

class ServicesController extends AvlController
{

  protected $langs = null;

  protected $section = null;

  public function __construct (Request $request) {
    parent::__construct($request);

    $this->langs = Langs::get();

    $this->section = ($request->id) ? Sections::findOrFail($request->id) : null;
  }

  public function index($id, Request $request)
  {
    // Запоминаем номер страницы на которой находимся
    $request->session()->put('page-services', $request->input('page') ?? 1);

    $services = Services::where('section_id', $this->section->id)->orderBy('published_at', 'DESC')->paginate(30);

    return view('avl.settings.sections.services.index', [
      'langs' => $this->langs,
      'section' => $this->section,
      'services' => $services
    ]);
  }

  public function create($id)
  {
    return view('avl.settings.sections.services.create', [
      'langs' => $this->langs,
      'section' => $this->section,
    ]);
  }

  public function store($id, Request $request)
  {
    $post = $request->input();

    $this->validate(request(), [
      'button' => 'required|in:add,save',
      'services_number' => '',
      'services_published_at' => 'required|date_format:"Y-m-d"',
      'services_published_time' => 'required|date_format:"H:i"',
      'services_region' => 'required|integer|min:1',

      'services_good_ru' => 'integer',
      'services_title_ru' => 'max:255',
      'services_description_ru' => '',
      'services_address_ru' => 'required',
      'services_address_license_ru' => '',
      'services_head_ru' => '',

      'services_coords' => 'required',
      'services_langs' => '',
      'services_phone' => '',
      'services_email' => '',
      'services_type' => '',
    ]);

    $service = new Services;

    $service->section_id = $id;

    foreach ($this->langs as $lang) {

      $service->{'good_' . $lang->key} = $post['services_good_' . $lang->key];
      $service->{'title_' . $lang->key} = $post['services_title_' . $lang->key];
      $service->{'description_' . $lang->key} = $post['services_description_' . $lang->key];

      $service->{'address_' . $lang->key} = $post['services_address_' . $lang->key];
      $service->{'address_license_' . $lang->key} = $post['services_address_license_' . $lang->key];
      $service->{'head_' . $lang->key} = $post['services_head_' . $lang->key];

    }

    $service->published_at = $post['services_published_at'] . ' ' . $post['services_published_time'];
    $service->created_user = Auth::user()->id;
    $service->number = $post['services_number'];
    $service->region = $post['services_region'];
    $service->coords = $post['services_coords'];
    if (isset($post['services_langs'])) { $service->langs = $post['services_langs']; }
    $service->phone = $post['services_phone'];
    $service->email = $post['services_email'];
    $service->type = $post['services_type'];


    if ($service->save()) {
      if ($post['button'] == 'add') {
        return redirect()->route('admin.settings.sections.services.create', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->route('admin.settings.sections.services.index', ['id' => $id, 'page' => $request->session()->get('page-services', '1')])->with(['success' => ['Сохранение прошло успешно!']]);
    }

    return redirect()->route('admin.settings.sections.services.create', ['id' => $id])->with(['errors' => ['Что-то пошло не так.']]);
  }

  public function show($id, $news_id)
  {
    return view('avl.settings.sections.services.show', [
      'langs' => $this->langs,
      'section' => $this->section,
    ]);
  }

  public function edit($id, $service_id)
  {
    return view('avl.settings.sections.services.edit', [
      'section' => $this->section,
      'langs' => $this->langs,
      'service' => Services::findOrFail($service_id)
    ]);
  }

  public function update(Request $request, $id, $service_id)
  {
    $post = $request->input();

    $this->validate(request(), [
      'button' => 'required|in:add,save',
      'services_number' => '',
      'services_published_at' => 'required|date_format:"Y-m-d"',
      'services_published_time' => 'required|date_format:"H:i"',
      'services_region' => 'required|integer|min:1',

      'services_good_ru' => 'integer',
      'services_title_ru' => 'max:255',
      'services_description_ru' => '',
      'services_address_ru' => 'required',
      'services_address_license_ru' => '',
      'services_head_ru' => '',

      'services_coords' => 'required',
      'services_langs' => '',
      'services_phone' => '',
      'services_email' => '',
      'services_type' => '',
    ]);

    $service = Services::findOrFail($service_id);

    foreach ($this->langs as $lang) {
      $service->{'good_' . $lang->key} = $post['services_good_' . $lang->key];
      $service->{'title_' . $lang->key} = $post['services_title_' . $lang->key];
      $service->{'description_' . $lang->key} = $post['services_description_' . $lang->key];

      $service->{'address_' . $lang->key} = $post['services_address_' . $lang->key];
      $service->{'address_license_' . $lang->key} = $post['services_address_license_' . $lang->key];
      $service->{'head_' . $lang->key} = $post['services_head_' . $lang->key];
    }

    $service->published_at = $post['services_published_at'] . ' ' . $post['services_published_time'];
    $service->update_user = Auth::user()->id;
    $service->number = $post['services_number'];
    $service->region = $post['services_region'];
    $service->coords = $post['services_coords'];
    if (isset($post['services_langs'])) { $service->langs = $post['services_langs']; }
    $service->phone = $post['services_phone'];
    $service->email = $post['services_email'];
    $service->type = $post['services_type'];


    if ($service->save()) {
      if ($post['button'] == 'add') {
        return redirect()->route('admin.settings.sections.services.create', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->route('admin.settings.sections.services.index', ['id' => $id, 'page' => $request->session()->get('page-services', '1')])->with(['success' => ['Сохранение прошло успешно!']]);
    }

    return redirect()->route('admin.settings.sections.services.create', ['id' => $id])->with(['errors' => ['Что-то пошло не так.']]);
  }

  public function destroy($id, $news_id)
  {
    //
  }

}
