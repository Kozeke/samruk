<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DestroyAndCreateGbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::dropIfExists('gbs');

			Schema::create('gbs', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('section_id')->nullable();
				$table->string('lang', 20)->nullable();
				$table->boolean('good')->default(0)->comment('Отображение');
				$table->string('surname')->nullable()->comment('Фамилия отправителя');
				$table->string('name')->nullable()->comment('Имя отправителя');
				$table->string('theme')->nullable()->comment('Тема вопроса');
				$table->string('email')->nullable()->comment('Email отправителя');
				$table->text('message')->nullable()->comment('Сообщение');
				$table->text('answer')->nullable()->comment('Ответ');
				$table->string('ip')->nullable();
				$table->dateTime('published_at')->default(now());
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
      Schema::dropIfExists('gbs');
    }
}
