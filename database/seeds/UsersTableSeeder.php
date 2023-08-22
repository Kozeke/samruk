<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('profiles')->truncate();

        DB::table('users')->insert([
            'good' => 1,
            'admin' => 1,
            'role_id' => 1,
            'email' => 'admin@ir.kz',
            'password' => bcrypt('111'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('profiles')->insert([
            'user_id' => 1,
            'iin' => 123456789012,
            'dob' => '1992-04-14',
            'name' => 'Администратор',
            'photo' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

    }
}
