<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Langs;

class CreatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('section_id')->comment('ID раздела');
					$table->boolean('good')->default(false)->comment('Вкл/Выкл');
					$table->integer('parent_id')->nullable()->comment('ID родительского элемента');
					$table->integer('sind')->nullable()->comment('порядок');

					$langs = Langs::all();
					foreach ($langs as $lang) { $table->string('title_' . $lang->key, 500)->nullable(); }

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
        Schema::dropIfExists('polls');
    }
}
