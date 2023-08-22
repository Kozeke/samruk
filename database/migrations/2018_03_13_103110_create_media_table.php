<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('media', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('section_id')->nullable();
				$table->integer('rubric_id')->nullable()->comment('Рубрика');
        $table->integer('news_id')->nullable();
        $table->integer('good')->default(1);
        $table->integer('main')->default(0);
        $table->string('type', 30)->nullable();
        $table->string('lang', 10)->nullable();
        $table->integer('sind')->nullable();
        $table->string('link')->nullable();
        $table->string('title_ru')->nullable();
        $table->dateTime('publish_at');
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
        Schema::dropIfExists('media');
    }
}
