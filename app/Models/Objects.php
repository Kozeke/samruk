<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use LaravelLocalization;

class Objects extends Model
{
		use ModelTrait;

		protected $table = 'objects';

		protected $modelName = __CLASS__;

		protected $guarded = [];

		protected $lang = null;

		public function __construct (array $attributes = array())
		{
			parent::__construct($attributes);

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
			return $this->hasMany('App\Models\Media', 'object_id')->where('type', $type);
		}

		public function videos ()
		{
			return $this->hasMany('App\Models\Media', 'object_id')->where('type', 'video');
		}

		public function images ()
		{
			return $this->media('image')->where('switch_' . $this->lang , true)->orderBy('main', 'desc')->orderBy('sind', 'desc')->get();
		}

		public function cover ()
		{
			$cover = $this->media('image')->where('switch_' . $this->lang , true)->orderBy('main', 'desc')->orderBy('sind', 'desc')->first();

			return !is_null($cover) ? $cover->link : '';
		}

		public function getTitleAttribute ($value, $lang = null) {
			$title = (!is_null($lang)) ? $lang : $this->lang;

			return ($this->{'title_' . $title}) ? $this->{'title_' . $title} : null ;
		}

		public function getAboutAttribute ($value, $lang = null) {
			$about = (!is_null($lang)) ? $lang : $this->lang;

			return ($this->{'about_' . $about}) ? $this->{'about_' . $about} : null ;
		}

		public function getInfrastructureAttribute ($value, $lang = null) {
			$infrastructure = (!is_null($lang)) ? $lang : $this->lang;

			return ($this->{'infrastructure_' . $infrastructure}) ? $this->{'infrastructure_' . $infrastructure} : null ;
		}

		public function getPlansAttribute ($value, $lang = null) {
			$plans = (!is_null($lang)) ? $lang : $this->lang;

			return ($this->{'plans_' . $plans}) ? $this->{'plans_' . $plans} : null ;
		}

		public function getCircsAttribute ($value, $lang = null) {
			$circs = (!is_null($lang)) ? $lang : $this->lang;

			return ($this->{'circs_' . $circs}) ? $this->{'circs_' . $circs} : null ;
		}

		public function getDeveloperAttribute ($value, $lang = null) {
			$developer = (!is_null($lang)) ? $lang : $this->lang;

			return ($this->{'developer_' . $developer}) ? $this->{'developer_' . $developer} : null ;
		}

		public function getLocationAttribute ($value, $lang = null) {
			$location = (!is_null($lang)) ? $lang : $this->lang;

			return ($this->{'location_' . $location}) ? $this->{'location_' . $location} : null ;
		}

		public function getUrlAttribute ($value, $lang = null) {
			return '/' . $this->lang . '/' . $this->section->type . '/' . $this->section->alias . '/' . $this->id ;
		}
}
