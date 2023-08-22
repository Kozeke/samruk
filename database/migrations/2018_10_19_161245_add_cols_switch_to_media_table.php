<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsSwitchToMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->boolean('switch_ru')->default(true)->after('good')->comment('Показать картинку на русском');
            $table->boolean('switch_kz')->default(true)->after('switch_ru')->comment('Показать картинку на казахском');
            $table->boolean('switch_en')->default(true)->after('switch_kz')->comment('Показать картинку на английском');
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
            $table->dropColumn('switch_ru');
            $table->dropColumn('switch_kz');
            $table->dropColumn('switch_en');
        });
    }
}
