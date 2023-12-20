<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('menu')->truncate();

        DB::table('menu')->insert([
            'title' => 'Главная',
            'icon_class' => 'fa fa-home',
            'url' => '',
            'order' => 1,
            'route' => 'home',
            'model' => 'Menu',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('menu')->insert([
            'title' => 'Настройки',
            'icon_class' => 'icon-settings',
            'url' => '',
            'order' => 2,
            'model' => 'Menu',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('menu')->insert([
            'title' => 'Роли',
            'parent_id' => 2,
            'icon_class' => 'fa fa-lock',
            'url' => '',
            'order' => 1,
            'route' => 'admin.settings.roles.index',
            'model' => 'App\Models\Roles',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('menu')->insert([
            'title' => 'Пользователи',
            'parent_id' => 2,
            'icon_class' => 'fa fa-users',
            'url' => '',
            'order' => 2,
            'route' => 'users.index',
            'model' => 'App\Models\User',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('menu')->insert([
          'title' => 'Настройка языков',
          'parent_id' => 2,
          'icon_class' => 'fa fa-language',
          'url' => '',
          'order' => 3,
          'route' => 'langs.index',
          'model' => 'Langs',
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('menu')->insert([
          'title' => 'Настройка шаблонов',
          'parent_id' => 2,
          'icon_class' => 'fa fa-sticky-note-o',
          'url' => '',
          'order' => 4,
          'route' => 'admin.settings.templates.index',
          'model' => 'Templates',
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('menu')->insert([
            'title' => 'Структура',
            'icon_class' => 'fa fa-tree',
            'url' => '',
            'order' => 3,
            'route' => 'admin.settings.sections.index',
            'model' => 'App\Models\Sections',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('menu')->insert([
            'title' => 'Настройки сайта',
            'icon_class' => 'icon-settings',
            'url' => '',
            'order' => 4,
            'model' => 'Menu',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('menu')->insert([
          'title' => 'Общие настройки',
          'parent_id' => 8,
          'icon_class' => 'icon-settings',
          'url' => '',
          'order' => 1,
          'route' => 'settings.index',
          'model' => 'Settings',
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);

    }
}
