<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCmsPdfToAppealHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appeal_history', function (Blueprint $table) {
            $table->text('cms_pdf');
            $table->text('base_pdf');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appeal_history', function (Blueprint $table) {
            $table->dropColumn('cms_pdf');
            $table->dropColumn('base_pdf');
        });
    }
}
