<?php namespace App\Http\Controllers\Avl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\SectionsTrait;
use App\Models\Areas;
use View;
use Auth;

class AvlController extends Controller
{
  use SectionsTrait;

  public $user = null;

  public $userArea = 1;

  public function __construct (Request $request)
  {
      $this->middleware(function ($request, $next) {
          $this->user = Auth::user();

          $this->userArea = $this->getAreaId($request);

          View::share('structures', SectionsTrait::tree(0, [], $this->userArea ?? 1));

          View::share('areas', $this->areasToSelect());

          View::share('userArea', $this->userArea);

          return $next($request);
      });
  }

  public function areasToSelect ()
  {
      $areas = [];

      foreach (Areas::all() as $area) {
          $areas[$area->id] = $area->title;
      }

      return $areas;
  }

  public function getAreaId (Request $request)
  {
    if ($this->user) {
      if ($this->user->role->name == 'admin') {
        return $request->session()->get('avl_area') ?? $this->user->area_id;
      }
      return $this->user->area_id;
    }
    return 1;
  }
}
