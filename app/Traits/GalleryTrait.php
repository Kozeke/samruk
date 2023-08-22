<?php namespace App\Traits;

use App\Models\Sections;
use LaravelLocalization;
use App\Traits\SectionsTrait;
use Cache;
/**
 * Functions by Models
 */
trait GalleryTrait
{
  use SectionsTrait;

  public static function getGallery ($alias = '')
  {
    return Cache::remember('col-gallery-' . LaravelLocalization::getCurrentLocale() . '-' . $alias, 20, function() use ($alias) {
      $section = Sections::where('type', 'gallery')->where('alias', $alias)->first();

      if (!is_null($section)) {
        $template = 'site.templates.gallery.col.' . self::getTemplateFileName($section->current_template->file_col);

        $galleries = $section ->galleries()
                              ->where('good_' . LaravelLocalization::getCurrentLocale(), 1)
                              ->orderBy('published_at', 'DESC')
                              ->limit($section->current_template->records_col)
                              ->get();

        return view($template, [
            'galleries' => $galleries,
            'section' => $section
        ])->render();
      }

      return false;
    });
  }

  public static function getTemplateFileName ($file)
  {
    return substr($file, 0, strpos($file, "."));
  }

}
