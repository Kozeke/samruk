<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use LaravelLocalization;

class Services extends Model
{
  use ModelTrait;

  protected $tables = 'services';

  protected $modelName = __CLASS__;

  protected $guarded = [];

  protected $casts = [
    'langs' => 'array',
  ];

  protected $lang = null;

  public function __construct ()
  {
    $this->lang = LaravelLocalization::getCurrentLocale();
  }

  public function getTitleAttribute ($value, $lang = null) {
    $title = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'title_' . $title}) ? $this->{'title_' . $title} : $this->title_ru ;
  }

  public function getDescriptionAttribute ($value, $lang = null) {
    $description = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'description_' . $description}) ? $this->{'description_' . $description} : $this->description_ru ;
  }

  public function getHeadAttribute ($value, $lang = null) {
    $head = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'head_' . $head}) ? $this->{'head_' . $head} : $this->head_ru ;
  }

  public function getAddressAttribute ($value, $lang = null) {
    $address = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'address_' . $address}) ? $this->{'address_' . $address} : $this->address_ru ;
  }

  public function getAddressLicenseAttribute ($value, $lang = null) {
    $address_license = (!is_null($lang)) ? $lang : $this->lang;

    return ($this->{'address_license_' . $address_license}) ? $this->{'address_license_' . $address_license} : $this->address_license_ru ;
  }

}
