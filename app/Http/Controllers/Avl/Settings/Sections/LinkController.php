<?php

namespace App\Http\Controllers\Avl\Settings\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\Sections;

class LinkController extends AvlController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
      $section = Sections::findOrFail($id);

      $this->authorize('update', $section);

      return view('avl.settings.sections.link.edit', [
          'section' => $section,
          'id' => $id
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
      $section = Sections::findOrFail($id);

      $this->authorize('update', $section);

      $data = $request->input();

      $section->link = $data['section_link'];

      if ($section->save()) {
        return redirect()->back()->with(['success' => ['Сохранение прошло успешно!']]);
      }
      return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
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
