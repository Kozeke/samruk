<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function currentRouteName ()
    {
        return \Route::getCurrentRoute() ? \Route::getCurrentRoute()->getName() : null;
    }

    public function getMenuByRouteName ()
    {
        return \App\Models\Menu::where('route', $this->currentRouteName())->firstOrFail();
    }

    public function getGlobalSettings ($lang = 'ru')
    {
      $data = [
        'title' => '',
        'description' => '',
        'keywords' => ''
      ];

      $settings = \App\Models\Settings::where('key', 'site')->first();

      if ($settings) {
        $title = 'title_' . $lang ;
        $description = 'description_' . $lang ;
        $keywords = 'keywords_' . $lang ;

        $data = [
          'title' => $settings->$title,
          'description' => $settings->$description,
          'keywords' => $settings->$keywords
        ];
      }
      return $data;
    }
}
