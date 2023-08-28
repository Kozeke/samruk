<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppealHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appeal_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('link')->nullable()->comment('ссылка на файл');
            $table->string('status')->nullable()->comment('статус обращения');
            $table->string('reply')->nullable()->comment('ответ на обращение');
            $table->string('user_id')->nullable()->comment('ответ на обращение');
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
        Schema::dropIfExists('appeal_history');
    }
}
