<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class Permissions extends Model
{
    use ModelTrait;

    protected $table = 'permission_role';

    protected $modelName = __CLASS__;

    protected $fillable = ['role_id', 'model', 'model_id', 'read', 'edit', 'add', 'delete'];

    /* Для таблиц у которых нет первичного ключа и полей $timestamps */
    public $timestamps = false;

    protected $primaryKey = null;

    public $incrementing = false;

}
