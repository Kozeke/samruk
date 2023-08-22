<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

      Blade::if('hideSidebar', function ($index = false, $section = null) {

        // если главная то показывать все былоки
        if ($index == true) { return true; }

        // если изначально у раздела не выставлены параметры
        if (!is_null($section) && is_null($section->configuration)) {
          return true;
        }

        // если убрано отображение всех блоков в колонке
        if (!is_null($section) && is_null($section->configuration->sidebar)) {
          return false;
        }

        // показать sidebar если хоть один блок включен
        if (!is_null($section) && !is_null($section->configuration->sidebar) ) {
          return true;
        }

        return false;
      });

      Blade::if('hideCol', function ($index = false, $section = null, $alias = null) {

        // если главная то показывать все былоки
        if ($index == true) { return true; }

        // если изначально у раздела не выставлены параметры
        if (!is_null($section) && is_null($section->configuration)) {
          return true;
        }

        // если убрано отображение всех блоков в колонке
        if (!is_null($section) && is_null($section->configuration->sidebar)) {
          return false;
        }

        // показать sidebar если хоть один блок включен
        if (!is_null($section) && ((isset($section->configuration->sidebar[$alias])) && ($section->configuration->sidebar[$alias] == 1)) ) {
          return true;
        }

        return false;
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
			// Переопределяем класс пакета
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			
			$loader->alias('ReCaptcha\RequestMethod\Post', 'App\ReCaptcha\RequestMethod\Post');

      // if ($this->app->environment('local')) {
      //   $this->app->register('JeroenG\Packager\PackagerServiceProvider');
      // }
    }
}
