<?php namespace App\Http\Controllers\Site\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\Sections\SectionsController;
use App\Models\Sections;
use Cache;

class ServicesController extends SectionsController
{

  public function index (Request $request)
  {
    $template = 'site.templates.services.short.' . $this->getTemplateFileName($this->section->current_template->file_short);

    $records = $this->getQuery($this->section->services(), $request);

    $records = $records->orderBy('published_at', 'DESC')->paginate($this->section->current_template->records);

    return view($template, [
        'records' => $records,
        'pagination' => $records->appends($_GET)->links(),
        'request' => $request
    ]);
  }

  public function show($alias, $id)
  {
    $template = 'site.templates.services.full.' . $this->getTemplateFileName($this->section->current_template->file_full);

    $service = $this->section->services()->findOrFail($id);

    return view($template, [
        'service' => $service
    ]);
  }

  public function data($alias)
  {
    $services = $this->section->services()->where('good_' . $this->lang, 1)->get();
    $data = [];
    if ($services) {
      foreach ($services as $service) {
        $data[] = [
          'coords' => $service->coords,
          'title' => $service->title,
          'head' => $service->head,
          'phone' => $service->phone,
          'address' => $service->address,
        ];
      }
    }
    return $data;
  }

  public function getQuery ($result, $request)
  {

    $result = $result->where('good_' . $this->lang, 1);

    // фильтр если приходит
    if ($request->input('region') && ($request->input('region') > 0)) {
      $result->where('region', $request->input('region'));
    }

    if ($request->input('type') && ($request->input('type') > 0)) {
      $result->where('type', $request->input('type'));
    }

    if ($request->input('number') && ($request->input('number') > 0)) {
      $result->where('number', $request->input('number'));
    }

    if ($request->input('lang') && ($request->input('lang') > 0)) {
      $result->where('langs', 'LIKE', "%{$request->input('lang')}%");
    }

    return $result;
  }

}
