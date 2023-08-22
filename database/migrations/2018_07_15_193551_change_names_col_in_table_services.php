<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNamesColInTableServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('services', function (Blueprint $table) {
        $table->renameColumn('address', 'address_ru');
        $table->renameColumn('address_license', 'address_license_ru');
        $table->renameColumn('head', 'head_ru');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
