<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ban')->nallable()->default(0);
            $table->string('title');
            $table->string('template');
            $table->integer('records')->default(10);
            $table->integer('sorting')->default(1);
            $table->integer('records_col')->default(5);
            $table->integer('sorting_col')->default(1);
            $table->string('file_short', 255)->default(null);
            $table->string('file_full', 255)->default(null);
            $table->string('file_col', 255)->default(null);
            $table->string('file_category', 255)->default(null);
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
        Schema::dropIfExists('templates');
    }
}
