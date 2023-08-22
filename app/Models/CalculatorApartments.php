<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class CalculatorApartments extends Model
{
    use ModelTrait;

    protected $tables = 'calculator_apartments';

    protected $modelName = __CLASS__;


}
