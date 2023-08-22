<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddObjectIdIntoMediaTable extends Migration
{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::table('media', function (Blueprint $table) {
					$table->integer('object_id')->nullable()->after('news_id');
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
					$table->dropColumn('object_id');
			});
		}
}
