<?php

namespace App\Http\Controllers\Avl\SiteSettings;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\Settings;
use App\Models\Langs;

class SettingsController extends AvlController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('view', new Settings);

      $settings = Settings::find(1);

      return view('avl.site_settings.settings.edit', [
          'settings' => $settings,
          'langs' => Langs::where('good', 1)->get(),
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->authorize('update', new Settings);

      $post = $request->input();
      $this->validate(request(), [
        'button' => 'required|in:add,save',
        'settings_title_ru' => 'required',
        'settings_description_ru' => '',
        'settings_keywords_ru' => '',
      ]);

      $settings = Settings::where('key', 'site')->firstOrFail();
      $langs = Langs::where('good', 1)->get();

      foreach ($langs as $lang) {
        $title_lang = 'title_' . $lang->key;
        $description_lang = 'description_' . $lang->key;
        $keywords_lang = 'keywords_' . $lang->key;

        if (isset($post['settings_'.$title_lang])) {
          $settings->$title_lang = $post['settings_'.$title_lang];
        } elseif (is_null($post['settings_'.$title_lang])) {
          $settings->$title_lang = null;
        }

        if (isset($post['settings_'.$description_lang])) {
          $settings->$description_lang = $post['settings_'.$description_lang];
        } elseif (is_null($post['settings_'.$description_lang])) {
          $settings->$description_lang = null;
        }
        if (isset($post['settings_'.$keywords_lang])) {
          $settings->$keywords_lang = $post['settings_'.$keywords_lang];
        } elseif (is_null($post['settings_'.$keywords_lang])) {
          $settings->$keywords_lang = null;
        }

      }

      if ($settings->save()) {
        return redirect()->back()->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
    }


}
