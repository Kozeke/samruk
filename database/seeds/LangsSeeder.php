<?php

use Illuminate\Database\Seeder;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LangsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('langs')->truncate();
      
      DB::table('langs')->insert([
        'good' => 1,
        'key' => 'ru',
        'name' => 'Русский',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
      ]);
    }
}
