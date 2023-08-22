<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('iin', 12)->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();
            $table->string('email')->nullable();
            $table->string('adds')->nullable()->comment('Адрес');
            $table->string('phone')->nullable()->comment('Домашний телефон');
            $table->string('mobile')->nullable()->comment('Мобильный телефон');
            $table->date('dob')->nullable()->comment('Дата рождения');
            $table->string('photo')->nullable()->comment('Фото профиля');
            $table->integer('sex')->nullable()->comment('Пол');
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
        Schema::dropIfExists('profiles');
    }
}
