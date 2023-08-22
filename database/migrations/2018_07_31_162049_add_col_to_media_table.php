<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('media', function (Blueprint $table) {
        $table->integer('gallery_id')->nullable()->after('news_id')->comment('ID галлереи');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('media', function (Blueprint $table) {
        $table->dropColumn('gallery_id');
      });
    }
}
