<?php namespace App\Http\Controllers\Avl\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\Templates;
use File;
use DB;

class TemplatesController extends AvlController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('view', new Templates);

      return view('avl.settings.templates.index', [
        'templates' => Templates::orderBy('title')->get()
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('create', new Templates);

      return view('avl.settings.templates.create', [
        'categoryFiles' => File::files(resource_path('views/site/templates/page/category')),
        'shortFiles' => File::files(resource_path('views/site/templates/page/short')),
        'fullFiles' => File::files(resource_path('views/site/templates/page/full')),
        'colFiles' => File::files(resource_path('views/site/templates/page/col'))
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
      $this->authorize('create', new Templates);

      $post = $this->validate(request(), [
          'template_name' => 'required|min:2',
          'template_template' => 'required|string|regex:/^[a-z]+$/i',
          'template_records' => 'required|integer',
          'template_sorting' => 'required|integer',
          'template_records_col' => 'required|integer',
          'template_sorting_col' => 'required|integer',
          'template_file_short' => 'required|string|not_in:0',
          'template_file_full' => 'required|string|not_in:0',
          'template_file_col' => 'required|string|not_in:0',
          'template_file_category' => 'required|string|not_in:0',
      ]);

      $template = new Templates;

      $template->title = $post['template_name'];
      $template->template = $post['template_template'];
      $template->records = $post['template_records'];
      $template->sorting = $post['template_sorting'];
      $template->records_col = $post['template_records_col'];
      $template->sorting_col = $post['template_sorting_col'];
      $template->file_short = $post['template_file_short'];
      $template->file_full = $post['template_file_full'];
      $template->file_col = $post['template_file_col'];
      $template->file_category = $post['template_file_category'];

      if ($template->save()) {
        return redirect()->route('admin.settings.templates.index')->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->route('admin.settings.templates.create')->with(['errors' => ['Что-то пошло не так.']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $this->authorize('view', new Templates);

      return view('avl.settings.templates.show', [
          'template' => \App\Models\Templates::findOrFail($id)
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
      $this->authorize('update', new Templates);

      $template = Templates::findOrFail($id);

      return view('avl.settings.templates.edit', [
        'template' => $template,
        'categoryFiles' => File::files(resource_path('views/site/templates/'. $template->template .'/category')),
        'shortFiles' => File::files(resource_path('views/site/templates/'. $template->template .'/short')),
        'fullFiles' => File::files(resource_path('views/site/templates/'. $template->template .'/full')),
        'colFiles' => File::files(resource_path('views/site/templates/'. $template->template .'/col'))
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
      $this->authorize('update', new Templates);

      $post = $this->validate(request(), [
          'template_name' => 'required|min:2',
          'template_records' => 'required|integer',
          'template_sorting' => 'required|integer',
          'template_records_col' => 'required|integer',
          'template_sorting_col' => 'required|integer',
          'template_file_short' => 'required|string|not_in:0',
          'template_file_full' => 'required|string|not_in:0',
          'template_file_col' => 'required|string|not_in:0',
          'template_file_category' => 'required|string|not_in:0',
      ]);

      $template = Templates::find($id);

      $template->title = $post['template_name'];
      $template->records = $post['template_records'];
      $template->sorting = $post['template_sorting'];
      $template->records_col = $post['template_records_col'];
      $template->sorting_col = $post['template_sorting_col'];
      $template->file_short = $post['template_file_short'];
      $template->file_full = $post['template_file_full'];
      $template->file_col = $post['template_file_col'];
      $template->file_category = $post['template_file_category'];

      if ($template->save()) {
        return redirect()->route('admin.settings.templates.index')->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->route('admin.settings.templates.create')->with(['errors' => ['Что-то пошло не так.']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->authorize('delete', new Templates);

      $template = Templates::findOrFail($id);

      if ($template) {
        /* Перед удалением шаблона надо изменить на дефолтный шаблон у всех разлеов у кого он применен */
        if ($template->sections()->count() > 0) {
          $defaultTemplate = Templates::where('template', $template->template)->where('ban', 1)->first();
          if ($defaultTemplate) {
            $affected = DB::update('UPDATE sections SET template = ? WHERE template = ?', [$defaultTemplate->id, $template->id]);
          }
        }
        if ($template->delete()) {
          return ['success' => ['Шаблон удален!']];
        }
      }
      return ['errors' => ['Что-то пошло не так']];
    }

    public function getTemplatesFiles (Request $request)
    {
      $post = $request->input();

      return [
        'categoryFiles' => $this->getFilesToArray(File::files(resource_path('views/site/templates/'. $post['type'] .'/category'))),
        'shortFiles' => $this->getFilesToArray(File::files(resource_path('views/site/templates/'. $post['type'] .'/short'))),
        'fullFiles' => $this->getFilesToArray(File::files(resource_path('views/site/templates/'. $post['type'] .'/full'))),
        'colFiles' => $this->getFilesToArray(File::files(resource_path('views/site/templates/'. $post['type'] .'/col')))
      ];
    }

    public function getTemplates (Request $request)
    {
      $post = $request->input();

      return [
        'templates' => Templates::where('template', $post['type'])->get()
      ];
    }

  private function getFilesToArray ($files)
  {
    $return = [];
    foreach ($files as $file) {
      $return[] = [
        'filename' => $file->getFilename(),
        'realPath' => $file->getRealPath(),
        'extension' => $file->getExtension(),
      ];
    }
    return $return;
  }

}
