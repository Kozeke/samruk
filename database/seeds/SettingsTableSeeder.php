<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('settings')->truncate();

          DB::table('settings')->insert([
            'key' => 'site',
            'title_ru' => 'IR.KZ',
            'description_ru' => 'IR.KZ',
            'keywords_ru' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
          ]);


    }
}
