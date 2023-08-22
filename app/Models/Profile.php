<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class Profile extends Model
{
  use ModelTrait;

  protected $tables = 'profile';

  protected $modelName = __CLASS__;

  protected $guarded = [];

}
