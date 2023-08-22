<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class PagesMedia extends Model
{
  use ModelTrait;

  protected $table = 'pages_media';

  protected $modelName = 'PagesMedia';

  protected $guarded = [];

}
