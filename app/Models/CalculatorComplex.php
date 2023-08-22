<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class CalculatorComplex extends Model
{
    use ModelTrait;

    protected $tables = 'calculator_complexes';

    protected $modelName = __CLASS__;

		public function apartments()
		{
			return $this->hasMany('App\Models\CalculatorApartments', 'complexe_id', 'id');
		}

}
