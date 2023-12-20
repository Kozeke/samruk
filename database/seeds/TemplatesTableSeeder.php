<?php

use Illuminate\Database\Seeder;

class TemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//      DB::table('templates')->truncate();

      DB::table('templates')->insert([
        'ban' => 1,
        'title' => 'По умолчанию',
        'template' => 'page',
        'records' => 10,
        'sorting' => 1,
        'records_col' => 3,
        'sorting_col' => 1,
        'file_short' => 'default.blade.php',
        'file_full' => 'default.blade.php',
        'file_col' => 'default.blade.php',
        'file_category' => 'default.blade.php',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
      ]);
      DB::table('templates')->insert([
        'ban' => 1,
        'title' => 'По умолчанию',
        'template' => 'news',
        'records' => 10,
        'sorting' => 1,
        'records_col' => 3,
        'sorting_col' => 1,
        'file_short' => 'default.blade.php',
        'file_full' => 'default.blade.php',
        'file_col' => 'default.blade.php',
        'file_category' => 'default.blade.php',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
      ]);
      DB::table('templates')->insert([
        'ban' => 1,
        'title' => 'По умолчанию',
        'template' => 'feedback',
        'records' => 10,
        'sorting' => 1,
        'records_col' => 3,
        'sorting_col' => 1,
        'file_short' => 'default.blade.php',
        'file_full' => 'default.blade.php',
        'file_col' => 'default.blade.php',
        'file_category' => 'default.blade.php',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
      ]);
      DB::table('templates')->insert([
        'ban' => 1,
        'title' => 'По умолчанию',
        'template' => 'gb',
        'records' => 10,
        'sorting' => 1,
        'records_col' => 3,
        'sorting_col' => 1,
        'file_short' => 'default.blade.php',
        'file_full' => 'default.blade.php',
        'file_col' => 'default.blade.php',
        'file_category' => 'default.blade.php',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
      ]);
    }
}
