<?php namespace App\Http\Controllers\Site\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\Sections\SectionsController;
use App\Models\Sections;
use Cache;

class GalleryController extends SectionsController
{

  public function index (Request $request)
  {

      $template = 'site.templates.gallery.short.' . $this->getTemplateFileName($this->section->current_template->file_short);

      $records = $this->getQuery($this->section->galleries(), $request);

      $records = $records->orderBy('published_at', 'DESC')->paginate($this->section->current_template->records);

      return view($template, [
          'records' => $records,
          'pagination' => $records->appends($_GET)->links()
      ]);

  }

  public function show($alias, $id)
  {

    // return Cache::remember('full-news-' . $this->lang . '-' . $id, 10, function() use ($alias, $id) {

      $template = 'site.templates.gallery.full.' . $this->getTemplateFileName($this->section->current_template->file_full);

      $data = $this->section->galleries()->where('good_' . $this->lang, 1)->findOrFail($id);

      $data->increment('view');

      if ($data) {
        $data->load(['media' => function($query) {
          $query->where('good', 1)->orderBy('main', 'DESC')->orderBy('sind', 'DESC');
        }]);
      }

      return view($template, [
        'data' => $data,
        'items' => $data->media,
      ]);
    // });
  }

  public function getQuery ($result, $request)
  {

    $result = $result->where('good_' . $this->lang, 1);

    $result = $result->with(['media' => function($query) {
      $query->whereGood(1)->orderBy('main', 'DESC')->orderBy('sind', 'DESC');
    }]);

    return $result;
  }

}
