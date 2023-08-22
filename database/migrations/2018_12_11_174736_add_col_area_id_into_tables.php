<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColAreaIdIntoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->integer('area_id')->default(1)->after('id')->comment('id района');
        });

        Schema::table('sections', function (Blueprint $table) {
          $table->integer('area_id')->default(1)->after('id')->comment('id района');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('area_id');
      });

      Schema::table('sections', function (Blueprint $table) {
        $table->dropColumn('area_id');
      });
    }
}
