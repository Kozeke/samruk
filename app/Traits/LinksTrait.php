<?php namespace App\Traits;

use App\Models\Sections;
use LaravelLocalization;
use Cache;

/**
 * Functions by Models
 */
trait LinksTrait
{

    public static function getLinks($alias = '', $templatePath = '')
    {
        $section = Sections::where('type', 'links')->where('alias', $alias)->first();

        if (!is_null($section)) {
            $template = 'site.templates.links.col.' . (($templatePath != '') ? $templatePath : self::getTemplateFileName($section->current_template->file_col));

            $links = Cache::remember('col-links-' . LaravelLocalization::getCurrentLocale() . '-' . $alias, 22 * 60,
                function () use ($section) {
                    return $section->links()->where('good_' . LaravelLocalization::getCurrentLocale(), 1)
                        ->orderBy('published_at', 'DESC')
                        ->limit($section->current_template->records_col)
                        ->get();
                });

            return view($template, [
                'links'   => $links,
                'section' => $section,
            ]);
        }
    }

    public static function getTemplateFileName($file)
    {
        return substr($file, 0, strpos($file, "."));
    }

}
