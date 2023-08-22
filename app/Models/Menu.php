<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class Menu extends Model
{
    use ModelTrait;
    
    protected $table = 'menu';

    protected $modelName = __CLASS__;

    public function children ()
    {
        return $this->hasMany('App\Models\Menu', 'parent_id', 'id');
    }
}
