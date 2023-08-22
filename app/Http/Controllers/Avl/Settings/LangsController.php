<?php namespace App\Http\Controllers\Avl\Settings;

use App\Http\Controllers\Avl\AvlController;
use Illuminate\Http\Request;
use App\Models\Langs;
use Schema;

class LangsController extends AvlController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('view', new Langs);

      return view('avl.settings.langs.index', [
        'langs' => Langs::paginate(20)
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', new Langs);

      return view('avl.settings.langs.create', [
        'existLangs' => Langs::all()->pluck('key')->toArray()
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', new Langs);

      $post = $this->validate(request(), [
          'button' => 'required|in:add,save',
          'lang_key' => 'required|unique:langs,key',
          'lang_name' => 'required|min:2'
      ]);

      $create = Langs::create([
          'good' => 1,
          'key' => $post['lang_key'],
          'name' => $post['lang_name']
      ]);

      if ($create) {
        $this->refresh();
        if ($post['button'] == 'add') {
          return redirect()->route('langs.create')->with(['success' => ['Сохранение прошло успешно!']]);
        }
        return redirect()->route('langs.index')->with(['success' => ['Сохранение прошло успешно!']]);
      }

      return redirect()->route('langs.create')->with(['errors' => ['Что-то пошло не так.']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $this->authorize('view', new Langs);

      return view('avl.settings.langs.show', [
        'lang' => Langs::findOrFail($id)
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $this->authorize('update', new Langs);

      return view('avl.settings.langs.edit', [
        'lang' => Langs::findOrFail($id)
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
      $this->authorize('update', new Langs);

      $post = $this->validate(request(), [
        // 'lang_key' => 'required|unique:langs,key,'.$id,
        'lang_name' => 'required|min:2'
      ]);

      $lang = Langs::findOrFail($id);
      if ($lang) {
        $lang->name = $post['lang_name'];

        if ($lang->save()) {
          return redirect()->route('langs.index')->with(['success' => ['Сохранение прошло успешно!']]);
        }
      }

      return redirect()->route('langs.edit', ['langs' => $id])->with(['errors' => ['Что-то пошло не так.']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->authorize('delete', new Langs);

      $lang = Langs::findOrFail($id);

      if ($lang) {
        if ($lang->delete()) {
          return ['success' => ['Запись удалена']];
        }
      }
      return ['errors' => ['Что-то пошло не так']];
    }

    public function refresh()
    {
      $langs = Langs::get();

      foreach ($langs as $lang) {
        if (!Schema::hasColumn('sections', 'name_' . $lang->key)) {
          Schema::table('sections', function($table) use($lang) {
            $table->string('name_' . $lang->key)->nullable()->after('name_ru');
          });
        }
        /* добавление поля в таблицу Pages */
        if (!Schema::hasColumn('pages', 'description_' . $lang->key)) {
          Schema::table('pages', function($table) use($lang) {
            $table->text('description_' . $lang->key)->nullable()->after('description_ru');
          });
        }

        /* добавление поля в таблицу News title */
        if (!Schema::hasColumn('news', 'title_' . $lang->key)) {
          Schema::table('news', function($table) use($lang) {
            $table->string('title_' . $lang->key)->nullable()->after('title_ru');
          });
        }
        if (!Schema::hasColumn('news', 'good_' . $lang->key)) {
          Schema::table('news', function($table) use($lang) {
            $table->integer('good_' . $lang->key)->default(0)->after('good_ru');
          });
        }
        if (!Schema::hasColumn('news', 'short_' . $lang->key)) {
          Schema::table('news', function($table) use($lang) {
            $table->text('short_' . $lang->key)->nullable()->after('short_ru');
          });
        }
        if (!Schema::hasColumn('news', 'full_' . $lang->key)) {
          Schema::table('news', function($table) use($lang) {
            $table->text('full_' . $lang->key)->nullable()->after('full_ru');
          });
        }

        /* добавление поля в таблицу Settings title */
        if (!Schema::hasColumn('settings', 'title_' . $lang->key)) {
          Schema::table('settings', function($table) use($lang) {
            $table->string('title_' . $lang->key)->nullable()->after('title_ru');
          });
        }
        if (!Schema::hasColumn('settings', 'description_' . $lang->key)) {
          Schema::table('settings', function($table) use($lang) {
            $table->text('description_' . $lang->key)->nullable()->after('description_ru');
          });
        }
        if (!Schema::hasColumn('settings', 'keywords_' . $lang->key)) {
          Schema::table('settings', function($table) use($lang) {
            $table->text('keywords_' . $lang->key)->nullable()->after('keywords_ru');
          });
        }

        if (!Schema::hasColumn('media', 'title_' . $lang->key)) {
          Schema::table('media', function($table) use($lang) {
            $table->string('title_' . $lang->key)->nullable()->after('title_ru');
          });
        }

        //добавление полей в таблицу LINKS
        if (!Schema::hasColumn('links', 'description_' . $lang->key)) {
          Schema::table('links', function($table) use($lang) {
            $table->text('description_' . $lang->key)->nullable()->after('description_ru');
          });
        }
        if (!Schema::hasColumn('links', 'title_' . $lang->key)) {
          Schema::table('links', function($table) use($lang) {
            $table->string('title_' . $lang->key)->nullable()->after('title_ru');
          });
        }
        if (!Schema::hasColumn('links', 'link_' . $lang->key)) {
          Schema::table('links', function($table) use($lang) {
            $table->string('link_' . $lang->key)->nullable()->after('link_ru');
          });
        }
        if (!Schema::hasColumn('links', 'photo_' . $lang->key)) {
          Schema::table('links', function($table) use($lang) {
            $table->string('photo_' . $lang->key)->nullable()->after('photo_ru');
          });
        }
        if (!Schema::hasColumn('links', 'good_' . $lang->key)) {
          Schema::table('links', function($table) use($lang) {
            $table->integer('good_' . $lang->key)->default(0)->after('good_ru');
          });
        }

        //добавление полей в таблицу Rubrics
          if (!Schema::hasColumn('rubrics', 'title_' . $lang->key)) {
            Schema::table('rubrics', function($table) use($lang) {
              $table->string('title_' . $lang->key)->nullable()->after('title_ru');
            });
          }
          if (!Schema::hasColumn('rubrics', 'description_' . $lang->key)) {
            Schema::table('rubrics', function($table) use($lang) {
              $table->text('description_' . $lang->key)->nullable()->after('description_ru');
            });
          }
          if (!Schema::hasColumn('rubrics', 'good_' . $lang->key)) {
            Schema::table('rubrics', function($table) use($lang) {
              $table->integer('good_' . $lang->key)->default(0)->after('good_ru');
            });
          }
          if (!Schema::hasColumn('rubrics', 'image_' . $lang->key)) {
            Schema::table('rubrics', function($table) use($lang) {
              $table->string('image_' . $lang->key)->nullable()->after('image_ru');
            });
          }

        // добавление полей в таблицу Rubrics
          if (!Schema::hasColumn('services', 'good_' . $lang->key)) {
            Schema::table('services', function($table) use($lang) {
              $table->integer('good_' . $lang->key)->default(0)->after('good_ru');
            });
          }
          if (!Schema::hasColumn('services', 'title_' . $lang->key)) {
            Schema::table('services', function($table) use($lang) {
              $table->string('title_' . $lang->key)->nullable()->after('title_ru');
            });
          }
          if (!Schema::hasColumn('services', 'description_' . $lang->key)) {
            Schema::table('services', function($table) use($lang) {
              $table->text('description_' . $lang->key)->nullable()->after('description_ru');
            });
          }
          if (!Schema::hasColumn('services', 'address_' . $lang->key)) {
            Schema::table('services', function($table) use($lang) {
              $table->text('address_' . $lang->key)->nullable()->after('address_ru');
            });
          }
          if (!Schema::hasColumn('services', 'address_license_' . $lang->key)) {
            Schema::table('services', function($table) use($lang) {
              $table->text('address_license_' . $lang->key)->nullable()->after('address_license_ru');
            });
          }
          if (!Schema::hasColumn('services', 'head_' . $lang->key)) {
            Schema::table('services', function($table) use($lang) {
              $table->text('head_' . $lang->key)->nullable()->after('head_ru');
            });
          }

      // добавление полей в таблицу Rubrics
        if (!Schema::hasColumn('configurations', 'name_' . $lang->key)) {
          Schema::table('configurations', function($table) use($lang) {
            $table->string('name_' . $lang->key)->nullable()->after('name_ru');
          });
        }
        if (!Schema::hasColumn('configurations', 'keywords_' . $lang->key)) {
          Schema::table('configurations', function($table) use($lang) {
            $table->string('keywords_' . $lang->key)->nullable()->after('keywords_ru');
          });
        }
        if (!Schema::hasColumn('configurations', 'description_' . $lang->key)) {
          Schema::table('configurations', function($table) use($lang) {
            $table->text('description_' . $lang->key)->nullable()->after('description_ru');
          });
        }

      // добавление полей в таблицу Rubrics
        if (!Schema::hasColumn('galleries', 'title_' . $lang->key)) {
          Schema::table('galleries', function($table) use($lang) {
            $table->string('title_' . $lang->key)->nullable()->after('title_ru');
          });
        }
        if (!Schema::hasColumn('galleries', 'description_' . $lang->key)) {
          Schema::table('galleries', function($table) use($lang) {
            $table->string('description_' . $lang->key)->nullable()->after('description_ru');
          });
        }
        if (!Schema::hasColumn('galleries', 'good_' . $lang->key)) {
          Schema::table('galleries', function($table) use($lang) {
            $table->integer('good_' . $lang->key)->default(0)->after('good_ru');
          });
        }

    }
    return ['success' => ['Обновление прошло успешно']];
  }

}
