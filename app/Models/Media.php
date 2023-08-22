<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use LaravelLocalization;

class Media extends Model
{
  use ModelTrait;

  protected $table = 'media';

  protected $modelName = __CLASS__;

  protected $fillable = ['section_id', 'news_id', 'good', 'main', 'type', 'lang', 'sind', 'link', 'title_ru', 'publish_at'];

  protected $lang = null;

  public function __construct ()
  {
    $this->lang = LaravelLocalization::getCurrentLocale();
  }

  public function scopeCover ($query)
  {
    return $query->where('good', 1)->orderBy('main', 'DESC')->orderBy('sind', 'DESC');
  }

  public function getTitleAttribute ($value, $lang = null) {
    $title = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'title_' . $title}) ? $this->{'title_' . $title} : $this->title_ru ;
  }
}
