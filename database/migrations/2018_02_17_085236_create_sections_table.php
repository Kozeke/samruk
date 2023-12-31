<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->text('rubric')->nullable()->comment('Поддержка рубрик');
            $table->integer('good')->nullable();
            $table->integer('menu')->nullable();
            $table->integer('order')->default(0);
            $table->string('type')->nullable();
            $table->string('link')->nullable();
            $table->string('name_ru')->nullable();
            $table->integer('template')->nullable();
            $table->integer('col')->nullable();
            $table->string('alias')->nullable();
            $table->string('classes')->nullable()->comment('Класс для разметки');
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
        Schema::dropIfExists('sections');
    }
}
