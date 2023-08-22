<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Langs;

class CreateCalculatorApartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::create('calculator_apartments', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('complexe_id');

				$langs = Langs::all();
				foreach ($langs as $lang) {
					$table->string('name_' . $lang->key, 500)->nullable();
				}

				$table->float('measure')->nullable()->comment('Квадратура');
				$table->double('cost_apartments', 15, 4)->nullable()->comment('Стоимость квартиры');

				$table->timestamps();
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('calculator_apartments');
    }
}
