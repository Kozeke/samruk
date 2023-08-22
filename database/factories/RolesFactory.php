<?php

use Faker\Generator as Faker;

$factory->defineAs(App\Models\Roles::class, 'roles', function (Faker $faker) {
    return [
      'name' => 'admin',
      'admin' => true,
      'display_name' => 'Роль администратора',
      'created_at' => date("Y-m-d H:i:s"),
      'updated_at' => date("Y-m-d H:i:s")
    ];
});
