<?php namespace App\Http\Controllers\Site\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\BaseController;
use App\Traits\Menu as MenuTrait;
use App\Models\{Sections};
use LaravelLocalization;
use View;

class SectionsController extends BaseController
{
  public $section = null;

  public function __construct(Request $request)
  {
    parent::__construct($request);

    $alias = (!is_null($request->alias)) ? $request->alias : null;

    if ($this->currentRouteName() == 'site.search') {
      $alias = 'search';
    }

    if (!is_null($alias)) {
      // $this->section = Sections::where('alias', $alias)->where('area_id', $this->domain->id ?? 1)->whereGood(1)->firstOrFail();
      $this->section = Sections::where('alias', $alias)->whereGood(1)->firstOrFail();

      View::share('section', $this->section);
      View::share('breadcrumbs', $this->getBreadCrumbs($this->section->id));
      View::share('pagination', false);
      View::share('indexPage', false);
      // View::share('extends', ($this->domain->alias != 'central') ? 'site.areas.pages' : 'site.templates.pages');
    }

  }

  public function getTemplateFileName ($file)
  {
    return substr($file, 0, strpos($file, "."));
  }

}
