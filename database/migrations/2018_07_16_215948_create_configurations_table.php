<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('configurations', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('section_id')->nullable();
        $table->string('name_ru')->nullable();
        $table->string('keywords_ru')->nullable();
        $table->text('description_ru')->nullable();
        $table->text('config')->nullable()->comment('Настройки раздела (кол-во записей нас траницу, шаблон)');
        $table->text('sidebar')->nullable();
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
      Schema::dropIfExists('configurations');
    }
}
