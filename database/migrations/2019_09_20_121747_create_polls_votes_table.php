<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_votes', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('poll_id')->comment('ID опроса');
					$table->integer('question_id')->comment('ID вопроса');
					$table->integer('answer_id')->comment('ID ответа');
					$table->string('ip', 30)->nullable()->comment('ip пользователя который проголосовал');
					$table->string('token')->nullable()->comment('token - запись из cookie');
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
        Schema::dropIfExists('poll_votes');
    }
}
