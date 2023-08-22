<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Langs;

class CreatePagesMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_media', function (Blueprint $table) {
            $table->increments('id');
						$table->integer('page_id')->nullable();
						$table->integer('slider')->nullable()->default(1);
						$table->integer('sind')->nullable();
						$table->string('good')->nullable()->default(1);

						$langs = Langs::all();
						foreach ($langs as $lang) {
							$table->string('title_' . $lang->key, 500)->nullable();
						}

						$table->string('link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_media');
    }
}
