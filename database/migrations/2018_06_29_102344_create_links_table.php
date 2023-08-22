<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('links', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('section_id')->nullable();
        $table->integer('good_ru')->default(0)->nullable();
        $table->string('link_ru')->nullable();
        $table->string('class')->nullable();
        $table->string('title_ru')->nullable();
        $table->text('description_ru')->nullable();
        $table->string('photo_ru')->nullable();
        $table->dateTime('published_at');
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
        Schema::dropIfExists('links');
    }
}
