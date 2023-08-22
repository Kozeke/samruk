<?php namespace App\Traits;

use Auth;

/**
 * Sections
 */

use App\Models\Sections;

trait SectionsTrait
{
    public static function tree($parent_id = 0, $data = [], $area = 1)
    {
        $return = $data;

        $sections = Sections::where('parent_id', $parent_id)->where('area_id', $area)
            ->with('current_template')->withCount('children')
            ->orderBy('order', 'ASC')->get();

        if ($sections) {
            foreach ($sections as $section) {
                if (Auth::check() && Auth::user()->checkRead($section)) {
                    $return[] = [
                        "id" => $section->id,
                        "good" => $section->good,
                        "menu" => $section->menu,
                        "rubric" => $section->rubric,
                        "type" => $section->type,
                        "order" => $section->order,
                        "template_id" => $section->template,
                        "template" => (!is_null($section->current_template)) ? $section->current_template->title : '',
                        "parent_id" => $section->parent_id,
                        "name_ru" => $section->name_ru,
                        "name_kz" => $section->name_kz,
                        "name_en" => $section->name_en,
                        "name" => $section->name,
                        "alias" => $section->alias,
                        "created_at" => $section->created_at,
                        "classes" => $section->classes,
                        "children" => ($section->children_count > 0) ? self::tree($section->id, $data, $area) : [],
                    ];
                }
            }
        }
        return $return;
    }

    public static function getSectionByAlias($alias = '')
    {
        return Sections::whereAlias($alias)->firstOrFail()->id;
    }

    public static function getMainParent($section = null)
    {
        if (!is_null($section)) {
            if (isset($section->parents) && $section->parents) {
                $parent = $section->parents()->first();

                if (!is_null($parent)) {
                    if ($parent->parent) {
                        return self::getMainParent($parent);
                    } else {
                        return $parent;
                    }
                }
            }
        }

        return $section;
    }

    public static function getParents($section = null)
    {
        if (!is_null($section)) {
            if (isset($section->children) && $section->children) {
                $childrenList = $section->children()->where('menu', 1)->get();

                // Если у текущего раздела есть "потомки", то возвращаем этот раздел
                if ($childrenList && $childrenList->count() && $section->submenu) {
                    return \App\Traits\Menu::get($section->id, []);
                }
            }

            // Вычисляем включен ли вывод подменю у первого родителя
            if (isset($section->parents) && $section->parents) {
                $parent = $section->parents()->first();

                if (!is_null($parent)) {
                    if ($parent->submenu) {
                        return \App\Traits\Menu::get($parent->id, []);
                    }
                    return self::getParents($parent);
                }
            }
        }

        return false;
    }
}
