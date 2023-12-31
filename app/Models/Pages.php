<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use LaravelLocalization;

class Pages extends Model
{
  use ModelTrait;

  protected $tables = 'pages';

  protected $modelName = __CLASS__;

  protected $lang = null;

  public function __construct ()
  {
    $this->lang = LaravelLocalization::getCurrentLocale();
  }

  public function getTextAttribute ($value, $lang = null) {
    $text = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'description_' . $text}) ? $this->{'description_' . $text} : null ;
  }

	public function images ()
	{
		return $this->hasMany('App\Models\PagesMedia', 'page_id', 'id');
	}
}
