<?php namespace App\Traits;

use App\Models\Sections;
use App\Traits\SectionsTrait;
use LaravelLocalization;

/**
 * Functions by Models
 */
trait PageTrait
{
    use SectionsTrait;

    public static function getPage($alias = '', $templatePath = '', $showImages = false)
    {
        $section = Sections::where('type', 'page')->where('alias', $alias)->whereGood(true)->first();

        if (!is_null($section)) {
            $template = 'site.templates.page.col.' . (($templatePath != '') ? $templatePath : self::getTemplateFileName($section->current_template->file_col));

            $text = '';
            $images = null;
            $page = (!is_null($section->page)) ? $section->page->toArray() : [];

            if ($showImages) {
                $images = (!is_null($section->page->images)) ? $section->page->images()->where('good', 1)->get() : null;
            }

            if (!empty($page)) {
                $text = $page['description_' . LaravelLocalization::getCurrentLocale()] ?? $page['description_ru'];
            }

            return view($template, [
                'text' => $text,
                'images' => $images,
                'section' => $section
            ])->render();
        }
        return false;
    }

    public static function getTemplateFileName($file)
    {
        return substr($file, 0, strpos($file, "."));
    }

}
