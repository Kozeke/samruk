<?php namespace App\Http\Controllers\Site\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\Sections\SectionsController;
use App\Models\Sections;
use Cache;
use View;

class PageController extends SectionsController
{
  public function index ()
  {
    // return Cache::remember('page--' . $this->lang . '-' . $this->section->id, 15, function() {

      $template = 'site.templates.page.full.' . $this->getTemplateFileName($this->section->current_template->file_full);

			$template = (View::exists($template)) ? $template : 'site.templates.page.full..default';
			
      return view($template, [
        'text' => (isset($this->section->page)) ? $this->section->page->text : '',
				'images' => (!is_null($this->section->page->images)) ? $this->section->page->images()->where('good', 1)->get() : null
      ]);
    // });
  }
}
