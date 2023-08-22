<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use LaravelLocalization;

class News extends Model
{
		use ModelTrait;

		protected $tables = 'news';

		protected $modelName = __CLASS__;

		protected $fillable = ['title_ru'];

		protected $lang = null;

		public function __construct ()
		{
			$this->lang = LaravelLocalization::getCurrentLocale();
		}

		public function section ()
		{
			return $this->belongsTo('App\Models\Sections', 'section_id', 'id');
		}

		public function rubric ()
		{
			return $this->belongsTo('App\Models\Rubrics', 'rubric_id', 'id');
		}

		public function media ($type = 'image')
		{
			return $this->hasMany('App\Models\Media', 'news_id')->where('type', $type);
		}

		public function videos ()
		{
			return $this->hasMany('App\Models\Media', 'news_id')->where('type', 'video');
		}

		public function cover ()
		{
			return $this->hasOne('App\Models\Media', 'news_id')->orderBy('main', 'desc')->orderBy('sind', 'desc');
		}

		public function sections ()
		{
			return $this->belongsToMany('App\Models\Sections', 'sections_news', 'news_id', 'section_id');
		}

		public function getGoodAttribute ($value, $lang = null) {
			$good = (!is_null($lang)) ? $lang : $this->lang;

			return ($this->{'good_' . $good}) ? $this->{'good_' . $good} : $this->good_ru ;
		}

		public function getTitleAttribute ($value, $lang = null) {
			$title = (!is_null($lang)) ? $lang : $this->lang;

			return ($this->{'title_' . $title}) ? $this->{'title_' . $title} : null ;
		}

		public function getShortAttribute ($value, $lang = null) {
			$short = (!is_null($lang)) ? $lang : $this->lang;

			return ($this->{'short_' . $short}) ? $this->{'short_' . $short} : $this->short_ru ;
		}

		public function getFullAttribute ($value, $lang = null) {
			$full = (!is_null($lang)) ? $lang : $this->lang;

			return ($this->{'full_' . $full}) ? $this->{'full_' . $full} : $this->full_ru ;
		}

		public function getUrlAttribute ($value, $lang = null) {
			return '/' . $this->lang . '/' . $this->section->type . '/' . $this->section->alias . '/' . $this->id ;
		}
}
