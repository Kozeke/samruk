<?php

if (!function_exists('menu')) {
		function menu()
		{
				return App\Traits\Menu::generate();
		}
}

if (!function_exists('menuAreas')) {
		function menuAreas($parent_id, $data)
		{
				return App\Traits\Menu::get($parent_id, $data);
		}
}

if (!function_exists('astana_url')) {
		function astana_url($url = '', $lang = true)
		{
				return env('APP_URL') . (($lang) ? '/' . LaravelLocalization::getCurrentLocale() : '') . $url;
		}
}

if (!function_exists('sub_url')) {
		function sub_url($url = '', $lang = true)
		{
				return '/' . LaravelLocalization::getCurrentLocale() . $url;
		}
}

if (!function_exists('getMainParent')) {
    function getMainParent($section = null)
    {
        return App\Traits\SectionsTrait::getMainParent($section);
    }
}

if (!function_exists('getParents')) {
	function getParents($section = null)
	{
		return App\Traits\SectionsTrait::getParents($section);
	}
}

if (!function_exists('getSectionByAlias')) {
		function getSectionByAlias($alias)
		{
				return App\Traits\SectionsTrait::getSectionByAlias($alias);
		}
}

if (!function_exists('getStructures')) {
		function getStructures($parent_id = 0, $data = [], $area = 1)
		{
				return App\Traits\SectionsTrait::tree($parent_id, $data, $area);
		}
}

if (!function_exists('delimetr')) {
	function delimetr ($delimetr = '', $count = 0)
	{
		$pre = $delimetr;
		if ($count > 0) {
			for ($i = 1; $i < $count; $i++) {
				$pre .= $delimetr;
			}
		}
		return $pre;
	}
}

if (!function_exists('getPage')) {
	function getPage($alias = '', $templatePath = '', $showImages = false)
	{
		return App\Traits\PageTrait::getPage($alias, $templatePath, $showImages);
	}
}

if (!function_exists('getNews')) {
		function getNews($alias = '', $templatePath = '')
		{
				return App\Traits\NewsTrait::getNews($alias, $templatePath);
		}
}

if (!function_exists('getGallery')) {
		function getGallery($alias = '')
		{
				return App\Traits\GalleryTrait::getGallery($alias);
		}
}

if (!function_exists('getLinks')) {
		function getLinks($alias = '', $templatePath = '')
		{
            return App\Traits\LinksTrait::getLinks($alias, $templatePath);
		}
}

if (!function_exists('getPoll')) {
		function getPoll($alias = '')
		{
				return App\Traits\PollsTrait::getPoll($alias);
		}
}

if (!function_exists('concatNumber')) {
	function concatNumber ($id = 0, $max = 2) : string
	{
			$str = '';
			if ($id > 0) {
				for ($i = strlen((string)$id); $i <= $max; $i++) {
					$str .= '0';
				}
				$str = $str.$id;
			}

			return $str;
	}
}

if (!function_exists('getNumber')) {
	function getNumber ($number = '') : array
	{
		preg_match_all('/(ZB([0-9]{1,})?-([0-9]{7}))/s', $number, $matches, PREG_SET_ORDER);

		return [
			'category' => (!empty($matches)) ? (int) $matches[0][2] : '',
			'id' => (!empty($matches)) ? (int) $matches[0][3] : '',
		];
	}
}

if (!function_exists('getCodeVideo')) {
	function getCodeVideo ($url) {
		$values = '';
		if ( preg_match( "/(http|https):\/\/(www.youtube|youtube|youtu)\.(be|com)\/([^<\s]*)/", $url, $match ) ) {
				if ( preg_match( '/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id ) ) {
						$values = $id[1];
				} else if ( preg_match( '/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id ) ) {
						$values = $id[1];
				} else if ( preg_match( '/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id ) ) {
						$values = $id[1];
				} else if ( preg_match( '/youtu\.be\/([^\&\?\/]+)/', $url, $id ) ) {
						$values = $id[1];
				} else if ( preg_match( '/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id )     ) {
						$values = $id[1];
				}
		}
		return $values;
	}
}

// Format file size
if (!function_exists('formatSize')) {
	function formatFileSize ($size) {

			$units = [' Б', ' Кб', ' Мб', ' Гб', ' Тб'];

			for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;

			return round($size, 2).$units[$i];
	}
}

// Format file
if (!function_exists('formatSize')) {
	function formatFile ($path) {
		return @pathinfo($path, PATHINFO_EXTENSION);
	}
}

// format date
if (!function_exists('formatDate')) {
	function formatDate ($date = '', $format = 'd M, Y')
	{

		$date = date($format, strtotime($date));

		$lang = \LaravelLocalization::getCurrentLocale();

		foreach(config('avl.inmonths.' . $lang) as $k => $v) {
			$date = str_replace($k, $v, $date);
		}

		return $date;
	}
}

// test
if (!function_exists('generateTemplate')) {
	function generateTemplate ($all = 0, $item = 0) {
		$return = '
			<div class="pull-right">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text p-0 pl-2 pr-2">
							<span>'.$item.' <i class="fa fa-user-circle-o"></i></span>
						</span>
						<span class="input-group-text p-0 pl-2 pr-2">';

							if ($item > 0) {
								$return .= '<span>'. round((100 * $item) / $all, 2) .' <i class="fa fa-percent"></i></span>';
							} else {
								$return .= '<span>0 <i class="fa fa-percent"></i></span>';
							}
						$return .= '
						</span>
					</div>
				</div>
			</div>';

			return $return;
	}
}

if (!function_exists('formatPhone')) {
	function formatPhone($number)
	{
			$str = strval($number);
			$str = '+' . substr($str, 0, 1) . ' (' . substr($str, 1, 3) . ') ' . substr($str, 4, 3) . '-' . substr($str, 7, 2) . '-' . substr($str, 9, 2);
			return $str;
	}
}

// Преобразование в массив для Form::select
if (!function_exists('toSelectTransform')) {
	function toSelectTransform ($records = []) : array
	{
		$return = [];
		if (is_array($records)) {
			foreach ($records as $record) {
				$return[$record['id']] = $record['title_ru'];
			}
		}
		return $return;
	}
}

// Версия для слабовидящих
if (!function_exists('special')) {
	function special () {
		if (isset($_COOKIE['spec_vers']) && $_COOKIE['spec_vers'] === 'true') {
			return 'special';
		} else {
			return '';
		}
	}
}

if (!function_exists('specialColor')) {
	function specialColor () {
		$color = isset($_COOKIE['color_scheme']) ? $_COOKIE['color_scheme'] : 'white';
		return 'spec-' . $color;
	}
}

if (!function_exists('specialFontSize')) {
	function specialFontSize () {
		$fontSize = isset($_COOKIE['font_size']) ? $_COOKIE['font_size'] : 'normal';
		return 'font-size-' . $fontSize;
	}
}

if (!function_exists('specialShowImages')) {
	function specialShowImages () {
		if (isset($_COOKIE['show_image']) && $_COOKIE['show_image'] === 'false') {
			return 'hide-images';
		} else {
			return '';
		}
	}
}

if (!function_exists('specialSiteLogoPath')) {
	function specialSiteLogoPath () {
		$color = isset($_COOKIE['color_scheme']) ? $_COOKIE['color_scheme'] : 'white';
		$imagePath = '/site/img/site-logo/special/' . $color;

		return $imagePath;
	}
}

// svg srite icon generate
if (!function_exists('icon')) {
	function icon ($name, $mod = '') {
		if ($mod) {
			$svgTemplate = '
				<svg class="icon '.$name.' '.$mod.'">
					<use xlink:href="#'.$name.'"></use>
				</svg>';
		} else {
			$svgTemplate = '
				<svg class="icon '.$name.'">
					<use xlink:href="#'.$name.'"></use>
				</svg>';
		}

		return $svgTemplate;
	}
}
// Склонение слов
if (!function_exists('pluralForm')) {
	function pluralForm($number, $before, $after) {
		$cases = array(2, 0, 1, 1, 1, 2);
		echo $before[($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)]].' '.$number.' '.$after[($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)]];
	}
}

// Траурная версия
if (!function_exists('isTraur')) {
    function isTraur () {
        return strtotime(date('d-m-Y')) == strtotime('10-01-2022');
    }
}

if (!function_exists('specialTraur')) {
    function specialTraur () {
        return isTraur() ? 'special-traur ' : '';
    }
}

if (!function_exists('getUpperLevels')) {
    function getUpperLevels($alias = null)
    {
        return App\Traits\Menu::getUpperLevels($alias);
    }
}
