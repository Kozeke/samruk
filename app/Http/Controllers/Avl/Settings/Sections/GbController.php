<?php

namespace App\Http\Controllers\Avl\Settings\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\{Sections, Langs, Gb};
use View;

class GbController extends AvlController
{

		protected $langs = null;

		protected $section;

		public function __construct (Request $request) {
			parent::__construct($request);

			$this->langs = Langs::get();

			$this->section = Sections::find($request->id) ?? null;

			View::share(['section' => $this->section]);
		}

		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index($id, Request $request)
		{
			$this->authorize('view', $this->section);

			$records = $this->section->gb()->orderBy('created_at', 'DESC');

            if (!is_null($request->input('name'))) {
                $records = $records->where('name', $request->input('name'));
            }
            if (!is_null($request->input('email'))) {
                $records = $records->where('email', $request->input('email'));
            }

			return view('avl.settings.sections.gb.index', [
				'records' => $records->paginate(30)
			]);
		}

		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			$this->authorize('create', $this->section);

			return view('avl.settings.sections.gb.create', [
				'langsArray' => $this->getLangsToSelect()
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
			$this->authorize('create', $this->section);

			$post = $request->input();

			$this->validate(request(), [
				'published_date' => 'required|date_format:"Y-m-d"',
				'published_time' => 'required|date_format:"H:i"'
			], [
				'published_date.required' => 'Формат даты не верен',
				'published_date.date_format' => 'Формат даты не верен',
				'published_time.required' => 'Формат времени не верен',
				'published_time.date_format' => 'Формат времени не верен',
			]);
			$gb = new Gb();

			$gb->name = $request->input('name') ?? null;
			$gb->surname = $request->input('surname') ?? null;
			$gb->email = $request->input('email') ?? null;
			$gb->theme = $request->input('theme') ?? null;
			$gb->message = $request->input('message') ?? null;
			$gb->answer = $request->input('answer') ?? null;
			$gb->lang = $request->input('lang');
			$gb->section_id = $this->section->id;
			$gb->published_at = $request->input('published_date') . ' ' . $request->input('published_time');

			if ($gb->save()) {
				return redirect()->route('admin.settings.sections.gb.index', ['id' => $this->section->id])->with(['success' => ['Сохранение прошло успешно!']]);
			}

			return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
		}

		/**
		 * Display the specified resource.
		 *
		 * @param  int  $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
				//
		}

		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  int  $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit(Request $request)
		{
			$this->authorize('update', $this->section);

			return view('avl.settings.sections.gb.edit', [
				'langsArray' => $this->getLangsToSelect(),
				'record' => Gb::findOrFail($request->gb)
			]);
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @param  int  $id
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request)
		{
			$this->authorize('update', $this->section);

			$post = $request->input();

			$this->validate(request(), [
				'published_date' => 'required|date_format:"Y-m-d"',
				'published_time' => 'required|date_format:"H:i"'
			], [
				'published_date.required' => 'Формат даты не верен',
				'published_date.date_format' => 'Формат даты не верен',
				'published_time.required' => 'Формат времени не верен',
				'published_time.date_format' => 'Формат времени не верен',
			]);

			$gb = Gb::findOrFail($request->gb);

			$gb->name = $request->input('name') ?? null;
			$gb->surname = $request->input('surname') ?? null;
			$gb->email = $request->input('email') ?? null;
			$gb->theme = $request->input('theme') ?? null;
			$gb->message = $request->input('message') ?? null;
			$gb->answer = $request->input('answer') ?? null;
			$gb->lang = $request->input('lang');
			$gb->section_id = $this->section->id;
			$gb->published_at = $request->input('published_date') . ' ' . $request->input('published_time');

			if ($gb->update()) {
				return redirect()->route('admin.settings.sections.gb.index', ['id' => $this->section->id])->with(['success' => ['Сохранение прошло успешно!']]);
			}

			return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int  $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy(Request $request)
		{
			$this->authorize('delete', $this->section);

			$gb = Gb::find($request->gb);

			if (!is_null($gb)) {
				if ($gb->delete()) {
					return ['success' => ['Запись удалена']];
				}
			}

			return ['errors' => ['Ошибка удаления.']];
		}

		protected function getLangsToSelect () : array
		{
			$records = Langs::all();
			if ($records->count() > 0) {
				foreach ($records as $record) {
					$return[$record->key] = $record->name;
				}
			}
			return $return ?? [];
		}
}
