<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class Gb extends Model
{
  use ModelTrait;

  protected $table = 'gbs';

  protected $modelName = __CLASS__;

	public function scopeGood ($query)
	{
		return $query->whereGood(true);
	}
}
