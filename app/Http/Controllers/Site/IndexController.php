<?php namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\BaseController;
use App\Models\{Sections, News, Rubrics};
use Carbon\Carbon;
use Cache;

class IndexController extends BaseController
{

	public function index ()
	{

		$section = Sections::whereType('news')->whereAlias('news')->first();

		// $indexTemplate = ($this->domain->alias != 'central') ? 'site.areas.index' : 'site.index' ;

		 return view('site.index', [
				 'indexPage' => true,
				 'section' => null
		 ]);
	}

}
