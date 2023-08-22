<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use LaravelLocalization;

class Report extends Model
{
    use ModelTrait;

    protected $table = 'report-meeting';

    protected $modelName = __CLASS__;

}
