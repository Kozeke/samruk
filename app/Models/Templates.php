<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class Templates extends Model
{
  use ModelTrait;

  protected $modelName = __CLASS__;

  public function sections ()
  {
    return $this->hasMany('App\Models\Sections', 'template', 'id');
  }
}
