<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use LaravelLocalization;

class Galleries extends Model
{
  use ModelTrait;
  
  protected $table = 'galleries';

  protected $modelName = __CLASS__;

  protected $guarded = [];

  protected $lang = null;

  public function __construct ()
  {
    $this->lang = LaravelLocalization::getCurrentLocale();
  }

  public function section ()
  {
    return $this->belongsTo('App\Models\Sections', 'section_id', 'id');
  }

  public function images()
  {
    return $this->hasMany('App\Models\Media', 'gallery_id', 'id')->whereType('image');
  }

  public function videos()
  {
    return $this->hasMany('App\Models\Media', 'gallery_id', 'id')->whereType('video');
  }

  public function media()
  {
    return $this->hasMany('App\Models\Media', 'gallery_id', 'id');
  }

  public function cover ()
  {
    return self::images()->orderBy('main', 'desc')->orderBy('sind', 'desc')->first();
  }

  public function getGoodAttribute ($value, $lang = null) {
    $good = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'good_' . $good}) ? $this->{'good_' . $good} : $this->good_ru ;
  }

  public function getTitleAttribute ($value, $lang = null) {
    $title = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'title_' . $title}) ? $this->{'title_' . $title} : $this->title_ru ;
  }

  public function getDescriptionAttribute ($value, $lang = null) {
    $description = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'description_' . $description}) ? $this->{'description_' . $description} : $this->description_ru ;
  }

  public function getPathAttribute ()
  {
    return '/' . $this->lang . '/' . $this->section->type . '/' . $this->section->alias . "/" . $this->id;
  }
}
