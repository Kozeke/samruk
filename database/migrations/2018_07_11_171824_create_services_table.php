<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('services', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('section_id')->nullable();
        $table->integer('good_ru')->default(0)->nullable();
        $table->string('title_ru')->nullable();
        $table->text('description_ru')->nullable();
        $table->integer('number')->nullable();
        $table->integer('region')->nullable();
        $table->string('address')->nullable();
        $table->string('coords')->nullable();

        $table->text('langs')->nullable();
        $table->string('head')->nullable();
        $table->string('phone')->nullable();
        $table->string('address_license')->nullable();
        $table->string('email')->nullable();
        $table->integer('type')->nullable()->comment('Тип школы (частная или гос)');

        $table->dateTime('published_at')->nullable();
        $table->integer('update_user')->nullable();
        $table->integer('created_user')->nullable();
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
      Schema::dropIfExists('services');
    }
}
