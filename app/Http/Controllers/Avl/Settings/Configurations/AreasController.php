<?php namespace App\Http\Controllers\Avl\Settings\Configurations;

use App\Http\Controllers\Avl\AvlController;
use App\Models\{Sections, Langs, Areas};
use Illuminate\Http\Request;

class AreasController extends AvlController
{

    protected $langs = null;

    public function __construct (Request $request)
    {
      parent::__construct($request);

      $this->langs = Langs::get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('avl.settings.configurations.areas.index', [
          'langs' => $this->langs,
          'records' => Areas::orderBy('id', 'asc')->paginate(50)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('avl.settings.configurations.areas.create', [
          'langs' => $this->langs
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
        $post = $this->validate(request(), [
          'alias' => 'required|regex:/^[a-z]+$/|unique:areas,alias',
          'title_ru' => 'required',
          'title_kz' => '',
          'title_en' => '',
        ], [
          'alias.required' => 'Alias не заполнен',
          'alias.regex' => 'Alias должен содержать только символы английского алфавита',
          'alias.unique' => 'Alias уже существует',
          'title_ru.required' => 'Название района не указано'
        ]);

        $area = new Areas();
        $area->alias = $post['alias'];
        foreach ($this->langs as $lang) {
          $area->{'title_' . $lang->key} = $post['title_' . $lang->key];
        }
        $area->added_id = $request->user()->id;
        $area->changed_id = $request->user()->id;

        if ($area->save()) {
            if ($request->input('button') == 'save') {
                return redirect()->route('admin.settings.configurations.areas.create')->with(['success' => ['Сохранено!!!']]);
            }
        }

        return redirect()->route('admin.settings.configurations.areas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('avl.settings.configurations.areas.show', [
          'langs' => $this->langs,
          'area' => Areas::findOrFail($id)
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
        return view('avl.settings.configurations.areas.edit', [
          'langs' => $this->langs,
          'area' => Areas::findOrFail($id)
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
        $area = Areas::findOrFail($id);

        $post = $this->validate(request(), [
          'alias' => 'required|regex:/^[a-z]+$/|unique:areas,alias,' . $id,
          'title_ru' => 'required',
          'title_kz' => '',
          'title_en' => '',
        ], [
          'alias.required' => 'Alias не заполнен',
          'alias.regex' => 'Alias должен содержать только символы английского алфавита',
          'alias.unique' => 'Alias уже существует',
          'title_ru.required' => 'Название района не указано'
        ]);

        $area->alias = $post['alias'];
        foreach ($this->langs as $lang) {
          $area->{'title_' . $lang->key} = $post['title_' . $lang->key];
        }
        $area->changed_id = $request->user()->id;

        if ($area->save()) {
            return redirect()->route('admin.settings.configurations.areas.index')->with(['success' => ['Сохранено!']]);
        }

        return redirect()->route('admin.settings.configurations.areas.index')->with(['success' => ['Сохранено!']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
