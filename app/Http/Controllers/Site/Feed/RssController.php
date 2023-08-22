<?php namespace App\Http\Controllers\Site\Feed;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\BaseController;
use App\Models\{Sections, News};

class RssController extends BaseController
{

  public function index ($id = 6)
  {
      $section = Sections::findOrFail($id);

      return view('site.feed.rss.index', [
        'records' => $section->news()->where('good_' . $this->lang, 1)->orderBy('published_at', 'DESC')->limit(20)->get(),
      ]);
  }

}
