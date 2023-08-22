<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRubricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubrics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id')->nullable();
            $table->integer('good_ru')->default(1);
            $table->string('title_ru')->nullable();
            $table->text('description_ru')->nullable();
            $table->string('image_ru')->nullable();
            $table->integer('update_user')->nullable();
            $table->integer('created_user')->nullable();
            $table->dateTime('published_at')->nullable();
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
        Schema::dropIfExists('rubrics');
    }
}
