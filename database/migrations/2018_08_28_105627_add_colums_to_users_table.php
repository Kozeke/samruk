<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('iin', 20)->nullable()->after('email')->comment('ИИН пользователя');
            $table->string('surname')->nullable()->after('iin')->comment('Фамилия');
            $table->string('name')->nullable()->after('surname')->comment('Имя');
            $table->string('patronymic')->nullable()->after('name')->comment('Отчество');
            $table->dateTime('last_login')->nullable()->after('patronymic')->comment('Последний раз онлайн');
            $table->boolean('locked')->nullable()->after('last_login')->comment('Заблокирован');
            $table->string('address')->nullable()->after('locked')->comment('Адрес');
            $table->string('homephone')->nullable()->after('address')->comment('Домашний телефон');
            $table->string('mobile')->nullable()->after('homephone')->comment('Мобильный телефон');
            $table->string('language', 5)->nullable()->after('mobile')->comment('Язык (ru, kz, en)');
            $table->dateTime('verify_at')->nullable()->after('verify')->comment('Истечение времени на подтверждение');
            $table->dateTime('password_requested_at')->nullable()->after('password')->comment('Ограничение времени на восстановление пароля');
            $table->string('photo')->nullable()->comment('Фото профиля');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('iin');
            $table->dropColumn('surname');
            $table->dropColumn('name');
            $table->dropColumn('patronymic');
            $table->dropColumn('last_login');
            $table->dropColumn('locked');
            $table->dropColumn('address');
            $table->dropColumn('homephone');
            $table->dropColumn('mobile');
            $table->dropColumn('language');
            $table->dropColumn('verify_at');
            $table->dropColumn('password_requested_at');
            $table->dropColumn('photo');
        });
    }
}
