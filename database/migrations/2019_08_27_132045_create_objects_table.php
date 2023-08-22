<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Langs;

class CreateObjectsTable extends Migration
{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
				Schema::create('objects', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('section_id');
					$table->integer('rubric_id')->nullable()->comment('Рубрика');
					$table->integer('program')->nullable()->comment('Программа');
					$table->integer('type')->nullable()->comment('Тип жилья');

					$langs = Langs::all();
					foreach ($langs as $lang) {
						$table->boolean('good_' . $lang->key)->default(false);
						$table->string('title_' . $lang->key, 500)->nullable();
						$table->mediumText('about_' . $lang->key)->nullable()->comment('О комплексе');
						$table->mediumText('infrastructure_' . $lang->key)->nullable()->comment('Инфраструктура');
						$table->mediumText('plans_' . $lang->key)->nullable()->comment('Планировки квартир');
						$table->mediumText('circs_' . $lang->key)->nullable()->comment('Условия покупки');
						$table->mediumText('developer_' . $lang->key)->nullable()->comment('O застройщике');
						$table->text('location_' . $lang->key)->nullable()->comment('Месторасположение');
					}

					$table->integer('created_id')->nullable();
					$table->dateTime('published_at')->nullable();
					$table->integer('view')->default(0)->nullable()->comment('Кол-во просмотров');
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
				Schema::dropIfExists('objects');
		}
}
