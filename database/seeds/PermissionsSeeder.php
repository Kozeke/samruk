<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->truncate();

        DB::table('permission_role')->insert([
            'role_id' => 2,
            'model' => 'Menu',
            'model_id' => 1,
            'read' => 1
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 2,
            'model' => 'Menu',
            'model_id' => 2,
            'read' => 1
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 2,
            'model' => 'Roles',
            'read' => 1,
            'edit' => 1,
            'delete' => 1
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 2,
            'model' => 'User',
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 2,
            'model' => 'Langs',
            'read' => 1,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 2,
            'model' => 'Langs'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 2,
            'model' => 'Sections'
        ]);
    }
}
