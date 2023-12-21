<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('roles')->truncate();

        factory(App\Models\Roles::class, 'roles', 1)->create();

        factory(App\Models\Roles::class, 'roles', 1)->create([
            'name' => 'content',
            'admin' => true,
            'display_name' => 'Роль контент менеджера',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        factory(App\Models\Roles::class, 'roles', 1)->create([
            'name' => 'guest',
            'admin' => false,
            'display_name' => 'Гость',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

    }
}
