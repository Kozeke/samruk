<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Langs;

class CreateCalculatorComplex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::create('calculator_complexes', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('section_id');

				$langs = Langs::all();
				foreach ($langs as $lang) {
					$table->string('title_' . $lang->key, 500)->nullable();
				}

				$table->double('rent_5', 15, 8)->nullable()->comment('Аренда 5 лет');
				$table->double('rent_7', 15, 8)->nullable()->comment('Аренда 7 лет');
				$table->double('rent_10', 15, 8)->nullable()->comment('Аренда 10 лет');
				$table->double('rent_15', 15, 8)->nullable()->comment('Аренда 15 лет');
				$table->double('cost', 15, 8)->nullable()->comment('Себестоимость');
				$table->double('purchase', 15, 8)->nullable()->comment('Стоимость продажи');

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
        Schema::dropIfExists('calculator_complexes');
    }
}
