<?php namespace App\Traits;

use App\Models\Sections;
use LaravelLocalization;
use Cache;

/**
 * Functions by Models
 */
trait PollsTrait
{

	public static function getPoll ($alias = '')
	{
			$section = Sections::where('type', 'polls')->where('alias', $alias)->first();

			if (!is_null($section)) {
				$template = 'site.templates.polls.col.' . self::getTemplateFileName($section->current_template->file_col) ?? 'default';

				$poll = $section->polls()->whereNull('parent_id')->where('good', true)->orderBy('sind', 'ASC')->first();
			}

			return view($template ?? 'site.templates.polls.col.default', [
				'poll' => $poll ?? null,
				'section' => $section
			]);
	}

	public static function getTemplateFileName ($file)
	{
		return substr($file, 0, strpos($file, "."));
	}

}
