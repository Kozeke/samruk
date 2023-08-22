<?php

namespace App\Http\Controllers\Avl\Settings\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\Sections;
use App\Models\CalculatorComplex;
use App\Models\CalculatorApartments;
use App\Models\Langs;

class CalculatorController extends AvlController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
      return view('avl.settings.sections.calculator.index', [
        'section' => Sections::find($id),
				'complexes' => CalculatorComplex::where('section_id', $id)->get(),
				'langs' => Langs::get()
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
			return view('avl.settings.sections.calculator.create', [
				'section' => Sections::find($id),
				'langs' => Langs::get()
			]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
			$post = $request->input();
			$langs = Langs::get();

			$this->validate(request(), [
				'button' => 'required|in:add,save,edit',
				'complexe_title_ru' => 'required',
				'complexe_rent_5' => 'required',
				'complexe_rent_7' => 'required',
				'complexe_rent_10' => 'required',
				'complexe_rent_15' => 'required',
				'complexe_cost' => 'required',
				'complexe_purchase' => 'required'
			]);

			$complexe = new CalculatorComplex;

			$complexe->section_id = $id;
			foreach ($langs as $lang) {
				$title_lang = 'title_' . $lang->key;
				$complexe->$title_lang = $post['complexe_'.$title_lang];
			}
			$complexe->rent_5 = $post['complexe_rent_5'];
			$complexe->rent_7 = $post['complexe_rent_7'];
			$complexe->rent_10 = $post['complexe_rent_10'];
			$complexe->rent_15 = $post['complexe_rent_15'];
			$complexe->cost = $post['complexe_cost'];
			$complexe->purchase = $post['complexe_purchase'];

			$complexe->save();
			if ($complexe) {
				return redirect()->route('calculator.index', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
			}

			return redirect()->route('calculator.create', ['id' => $id])->with(['errors' => ['Что-то пошло не так.']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $complexe_id)
    {
			return view('avl.settings.sections.calculator.show', [
				'langs' => Langs::get(),
				'complex' => CalculatorComplex::findOrFail($complexe_id),
				'id' => $id
			]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $complexe_id)
    {
			return view('avl.settings.sections.calculator.edit', [
				'langs' => Langs::get(),
				'complexe' => CalculatorComplex::findOrFail($complexe_id),
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
    public function update(Request $request, $id, $complexe_id)
    {
			$post = $request->input();
			$langs = Langs::get();

			$this->validate(request(), [
				'button' => 'required|in:add,save,edit',
				'complexe_title_ru' => 'required',
				'complexe_rent_5' => 'required',
				'complexe_rent_7' => 'required',
				'complexe_rent_10' => 'required',
				'complexe_rent_15' => 'required',
				'complexe_cost' => 'required',
				'complexe_purchase' => 'required'
			]);

			$complexe = CalculatorComplex::findOrFail($complexe_id);

			$complexe->section_id = $id;

			foreach ($langs as $lang) {
				$title_lang = 'title_' . $lang->key;
				$complexe->$title_lang = $post['complexe_'.$title_lang];
			}
			$complexe->rent_5 = $post['complexe_rent_5'];
			$complexe->rent_7 = $post['complexe_rent_7'];
			$complexe->rent_10 = $post['complexe_rent_10'];
			$complexe->rent_15 = $post['complexe_rent_15'];
			$complexe->cost = $post['complexe_cost'];
			$complexe->purchase = $post['complexe_purchase'];

			$complexe->save();
			if ($complexe) {
				return redirect()->route('calculator.index', ['id' => $id])->with(['success' => ['Сохранение прошло успешно!']]);
			}

			return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $complexe_id)
    {
			$data = CalculatorComplex::find($complexe_id);
	    if (!is_null($data)) {

				if($data->apartments()->count() > 0) {
					foreach ($data->apartments()->get() as $apartment) {
	          $apartment->delete();
	        }
				}

	      if ($data->delete()) {
	        return ['success' => ['Комплекс удален']];
	      }
	    }

	    return ['errors' => ['Ошибка удаления.']];
    }

		/** Апартаменты */

		public function apartment_index($id, $complexe_id)
		{
			return view('avl.settings.sections.calculator.apartment.index', [
        'section' => Sections::find($id),
				'complex' => CalculatorComplex::findOrFail($complexe_id),
				'apartments' => CalculatorApartments::where('complexe_id', $complexe_id)->get()
      ]);
		}


		public function apartment_create($id, $complexe_id)
		{
			return view('avl.settings.sections.calculator.apartment.create', [
				'langs' => Langs::get(),
        'section' => Sections::find($id),
				'complex' => CalculatorComplex::findOrFail($complexe_id),
      ]);
		}

		public function apartment_store(Request $request, $id, $complexe_id)
		{
			$post = $request->input();
			$langs = Langs::get();

			$this->validate(request(), [
				'button' => 'required|in:add,save,edit',
				'apartment_name_ru' => 'required',
				'apartment_measure' => 'required'
			]);

			$apartment = new CalculatorApartments;

			$apartment->complexe_id = $complexe_id;

			foreach ($langs as $lang) {
				$name_lang = 'name_' . $lang->key;
				$apartment->$name_lang = $post['apartment_'.$name_lang];
			}

			$apartment->measure = $post['apartment_measure'];

			$complex = CalculatorComplex::findOrFail($complexe_id);
			$purchase = $complex->purchase;
			$apartment_cost = $post['apartment_measure'] * $purchase;

			$apartment->cost_apartments = $apartment_cost;

			$apartment->save();
			if ($apartment) {
				return redirect()->route('calculator.apartment_index', ['id' => $id, 'complex_id' => $complexe_id])->with(['success' => ['Сохранение прошло успешно!']]);
			}

			return redirect()->route('calculator.apartment_create', ['id' => $id, 'complex_id' => $complexe_id])->with(['errors' => ['Что-то пошло не так.']]);
		}

		public function apartment_edit($id, $complexe_id, $apartment_id)
		{
			return view('avl.settings.sections.calculator.apartment.edit', [
				'langs' => Langs::get(),
        'section' => Sections::find($id),
				'complex' => CalculatorComplex::findOrFail($complexe_id),
				'apartment' => CalculatorApartments::findOrFail($apartment_id)
      ]);
		}

		public function apartment_update(Request $request, $id, $complexe_id, $apartment_id)
		{
			$post = $request->input();
			$langs = Langs::get();

			$this->validate(request(), [
				'button' => 'required|in:add,save,edit',
				'apartment_name_ru' => 'required',
				'apartment_measure' => 'required'
			]);

			$apartment = CalculatorApartments::findOrFail($apartment_id);

			foreach ($langs as $lang) {
				$name_lang = 'name_' . $lang->key;
				$apartment->$name_lang = $post['apartment_'.$name_lang];
			}
			$apartment->measure = $post['apartment_measure'];

			$complex = CalculatorComplex::findOrFail($complexe_id);
			$purchase = $complex->purchase;
			$apartment_cost = $post['apartment_measure'] * $purchase;

			$apartment->cost_apartments = $apartment_cost;

			$apartment->save();
			if ($apartment) {
				return redirect()->route('calculator.apartment_index', ['id' => $id, 'complex_id' => $complexe_id])->with(['success' => ['Сохранение прошло успешно!']]);
			}

			return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
		}

		public function apartment_destroy($id, $complexe_id, $apartment_id)
		{
			$data = CalculatorApartments::find($apartment_id);
			if (!is_null($data)) {

				if ($data->delete()) {
					return ['success' => ['Жилое помещение удалено']];
				}
			}

			return ['errors' => ['Ошибка удаления.']];
		}
}
