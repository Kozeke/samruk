<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddViewColToGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('galleries', function (Blueprint $table) {
        $table->integer('view')->default(0)->comment('Кол-во просмотров');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('galleries', function (Blueprint $table) {
        $table->dropColumn('view');
      });
    }
}
