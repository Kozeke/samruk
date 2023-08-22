<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use LaravelLocalization;

class Rubrics extends Model
{
  use ModelTrait;

  protected $tables = 'rubrics';

  protected $modelName = __CLASS__;

  protected $guarded = [];

  protected $lang = null;

  public function __construct ()
  {
    $this->lang = LaravelLocalization::getCurrentLocale();
  }

  public function news ()
  {
    return $this->hasMany('App\Models\News', 'rubric_id', 'id');
  }

  public function section ()
  {
    return $this->belongsTo('App\Models\Sections', 'section_id', 'id');
  }

  public function files ()
  {
    return $this->hasMany('App\Models\Media', 'rubric_id', 'id')->whereType('file');
  }

  public function images ()
  {
    return $this->hasMany('App\Models\Media', 'rubric_id', 'id')->whereType('image');
  }

  public function getTitleAttribute ($value, $lang = null) {
    $title = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'title_' . $title}) ? $this->{'title_' . $title} : $this->title_ru ;
  }

  public function getDescriptionAttribute ($value, $lang = null) {
    $description = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'description_' . $description}) ? $this->{'description_' . $description} : $this->description_ru ;
  }

	public function scopeGood ($query)
	{
		return $query->where('good_' . $this->lang, true);
	}
}
