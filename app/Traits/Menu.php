<?php namespace App\Traits;

use App\Models\Menu as MenuModel;
use App\Models\Sections;
use Auth;
use LaravelLocalization;

/**
 * Вывод меню в админ панели
 */
trait Menu
{

    public static function get($parent_id = 0, $data = [])
    {
        $return = $data;

        $sections = Sections::where('parent_id', $parent_id)->where('good', 1)
            ->where('menu', 1)
            ->withCount('children')
            ->orderBy('order')
            ->get();

        if ($sections) {
            foreach ($sections as $section) {
                $return[$section->id] = $section->toArray();
                $return[$section->id]['link'] = ($section->type == 'link') ? $section->link : '/' . $section->type . '/' . $section->alias;
                $return[$section->id]['children'] = $section->children_count ? self::get($section->id, $data) : [];
            }
        }
        return $return;
    }

    public static function generate($id = null, $data = [])
    {
        $return = $data;
        $records = MenuModel::where('parent_id', $id)->withCount('children')->orderBy('order')->get();

        if ($records) {
            foreach ($records as $record) {
                // $findOrNew = ($record->model == 'App\Models\Menu') ? $record->model::find($record->id) : new $record->model ;
                $findOrNew = \App\Models\Menu::find($record->id);
                if (Auth::user()->checkRead($findOrNew)) {
                    $return[] = [
                        "id" => $record->id,
                        "parent_id" => $record->parent_id,
                        "title" => $record->title,
                        "url" => $record->url,
                        "target" => $record->target,
                        "route" => $record->route,
                        "icon_class" => $record->icon_class,
                        "order" => $record->order,
                        "children" => ($record->children_count > 0) ? self::generate($record->id, $data) : [],
                    ];
                }
            }
        }
        return $return;
    }

    protected function hasSubmenu($section)
    {
        return ($section) ? ($section->children()->get()) ? true : false : false;
    }

    public static function getFirstLevel($section_id)
    {
        $section = Sections::where('id', $section_id)->where('good', 1)->where('menu', 1)->withCount('parents')->first();
        if (!is_null($section)) {
            if ($section->parents_count > 0) {
                $section = self::getFirstLevel($section->parent_id);
            }
        }

        return $section;
    }

    /**
     * Построение хлебных крошек
     *
     * @param $id текущий раздел
     * @param $home название для заголовка главной страницы
     *
     * @return string
     */
    protected static function getBreadCrumbs($id = 0, $return = [])
    {
        $data = $return;
        $section = Sections::where('id', $id)->withCount('parents')->first();
        if ($section) {
            $data[] = [
                "link" => ($section->type == 'link') ? $section->link : '/' . $section->type . '/' . $section->alias,
                "name" => $section->name
            ];
            if ($section->parents_count > 0) {
                $data = self::getBreadCrumbs($section->parent_id, $data);
            }
        }
        krsort($data);
        return $data;
    }

    public static function getUpperLevels($alias = null, $aliases = []): array
    {
        $data = $aliases;
        if (!is_null($alias)) {
            $section = Sections::where('alias', $alias)->withCount('parents')->first();
            if (!is_null($section)) {
                if ($section->parents_count > 0) {
                    $parent = $section->parents()->first();
                    $aliases = self::getUpperLevels($parent->alias, $data);
                }
                $aliases[] = $alias;
            }

            return $aliases;
        }
        return [];
    }

}
