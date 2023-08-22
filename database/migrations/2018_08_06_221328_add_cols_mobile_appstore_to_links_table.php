<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsMobileAppstoreToLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('links', function (Blueprint $table) {
        $table->string('appstore')->nullable()->comment('Ссылкана IOS приложение');
        $table->string('market')->nullable()->comment('Ссылкана Play Market приложение');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('links', function (Blueprint $table) {
        $table->dropColumn('appstore');
        $table->dropColumn('market');
      });
    }
}
