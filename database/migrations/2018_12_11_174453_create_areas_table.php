<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('good')->default(true);
            $table->string('alias')->nullable()->comment('alias поддомена для района');
            $table->string('title_ru')->nullable()->comment('Название района на русском языке');
            $table->string('title_kz')->nullable()->comment('Название района на казахском языке');
            $table->string('title_en')->nullable()->comment('Название района на английском языке');
            $table->integer('added_id')->nullable()->comment('кто добавил запись');
            $table->integer('changed_id')->nullable()->comment('кто изменил запись');
            $table->timestamps();
        });

        // Сразу создаем первую запись
        DB::table('areas')->insert([
          'good' => true,
          'alias' => 'central',
          'title_ru' => 'Акимата города Астаны',
          'added_id' => 'null',
          'changed_id' => 'null',
          'created_at' => now(),
          'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
