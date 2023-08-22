<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class Settings extends Model
{
    use ModelTrait;

    protected $tables = 'settings';

    protected $modelName = __CLASS__;


}
