<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('consent_to_data_collection')->default(0)->after('photo');
            $table->date('date_of_consent')->after('consent_to_data_collection')->nullable();
            $table->string('device')->nullable()->after('date_of_consent');
            $table->string('work_phone')->nullable()->after('homephone')->comment('Рабочий телефон');
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
            $table->dropColumn('consent_to_data_collection');
        });
    }

}
