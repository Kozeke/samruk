<?php namespace App\Http\Controllers\Site\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\Sections\SectionsController;
use App\Models\{Sections, News, Pages};
use DB;
use Illuminate\Pagination\Paginator;

class SearchController extends SectionsController
{
  public function index (Request $request)
  {
      $records = null;

      if ($request->input('query')) {

        // $records = DB::table('sections')->whereIn('type', ['page', 'news'])->whereGood(1)->whereMenu(1)
        //               ->leftJoin('pages', 'sections.id', '=', 'pages.section_id')
        //               ->leftJoin('news', 'sections.id', '=', 'news.section_id')
        //               // ->leftJoin('pages', function ($joinPages) use($request) {
        //               //     $joinPages->on('sections.id', '=', 'pages.section_id')
        //               //           ->where(function ($query) use($request) {
        //               //             $query->whereNotNull('description_' . $this->lang)
        //               //                   ->where('description_' . $this->lang, 'LIKE', '%' . $request->input('query') . '%');
        //               //           });
        //               //
        //               // })
        //               // ->leftJoin('news', function ($joinNews) use($request) {
        //               //   $joinNews->on('sections.id', '=', 'news.section_id')->where(function ($query) use($request) {
        //               //     $query->where('title_' . $this->lang, 'LIKE', '%' . $request->input('query') . '%')
        //               //           ->orWhere('short_' . $this->lang, 'LIKE', '%' . $request->input('query') . '%')
        //               //           ->orWhere('full_' . $this->lang, 'LIKE', '%' . $request->input('query') . '%');
        //               //   });
        //               ->select(
        //                 'sections.id',
        //                 'sections.type',
        //                 'sections.alias',
        //                 'sections.name_ru',
        //                 'sections.name_kz',
        //                 'sections.name_en',
        //                 'pages.description_ru',
        //                 'pages.description_kz',
        //                 'pages.description_en',
        //                 'news.id as news_id',
        //                 'news.title_ru', 'news.title_kz', 'news.title_en',
        //                 'news.short_ru', 'news.short_kz', 'news.short_en',
        //                 'news.full_ru', 'news.full_kz', 'news.full_en'
        //               )->where(function ($query) use($request) {
        //                 $query
        //                       ->where('pages.description_' . $this->lang, 'LIKE', '%' . $request->input('query') . '%')
        //                       ->orWhere('news.title_' . $this->lang, 'LIKE', '%' . $request->input('query') . '%')
        //                       ->orWhere('news.short_' . $this->lang, 'LIKE', '%' . $request->input('query') . '%')
        //                       ->orWhere('news.full_' . $this->lang, 'LIKE', '%' . $request->input('query') . '%');
        //               });

        $records = News::where(function ($query) use($request) {
                      $query->orWhere('news.title_' . $this->lang, 'LIKE', '%' . $request->input('query') . '%')
                            ->orWhere('news.short_' . $this->lang, 'LIKE', '%' . $request->input('query') . '%')
                            ->orWhere('news.full_' . $this->lang, 'LIKE', '%' . $request->input('query') . '%');
                    })->whereHas('section')->with('section');

        $records = $records->orderBy('published_at', 'DESC')->paginate(10);
        // dd($records);
      }

    // dd($records->appends($_GET)->links());
      return view('site.templates.search.short.default', [
        'records' => $records,
        'pagination' => ($records) ? $records->appends($_GET)->links() : null,
      ]);
  }
}
