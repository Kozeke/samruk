<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id');
						$table->integer('rubric_id')->nullable()->comment('Рубрика');
            $table->integer('good_ru');
            $table->string('title_ru')->nullable();
            $table->text('short_ru')->nullable();
            $table->mediumText('full_ru')->nullable();
            $table->integer('update_user')->nullable();
            $table->integer('created_user')->nullable();
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
        Schema::dropIfExists('news');
    }
}
