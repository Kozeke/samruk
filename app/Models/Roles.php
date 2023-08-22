<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class Roles extends Model
{
    use ModelTrait;

    protected $tables = 'roles';

    protected $modelName = __CLASS__;

    protected $fillable = ['name', 'display_name'];

    public function permissions ()
    {
        return $this->hasMany('App\Models\Permissions', 'role_id', 'id');
    }

    public function users ()
    {
        return $this->hasMany('App\Models\User', 'role_id', 'id');
    }

}
