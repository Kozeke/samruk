<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class Langs extends Model
{
  use ModelTrait;
  
  protected $table = 'langs';

  protected $modelName = __CLASS__;

  protected $fillable = ['key', 'name'];

}
