<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use LaravelLocalization;

class Areas extends Model
{
  use ModelTrait;

  protected $table = 'areas';

  protected $modelName = __CLASS__;

  protected $guarded = [];

  protected $lang = null;

  public function __construct ()
  {
      $this->lang = LaravelLocalization::getCurrentLocale();
  }

  public function getTitleAttribute ($value, $lang = null) {
      $title = (!is_null($lang)) ? $lang : $this->lang;

      return ($this->{'title_' . $title}) ? $this->{'title_' . $title} : $this->title_ru ;
  }
}
