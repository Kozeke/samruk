<?php

namespace App\Http\Controllers\Site\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\Sections\SectionsController;
use Validator;

class PollingController extends SectionsController
{
	public function index (Request $request)
	{
		$result = null;

		if ($request->input()) {

			$date = $request->input('birthdate') ? date('Y-m-d', strtotime($request->input('birthdate'))) : null;

			if ( !is_null($request->input('iin')) ) {

				$validator = Validator::make($request->input(), [
					'iin' => 'regex:/[0-9]{12}/',
				], [
					'iin.regex' => 'Некоректно введен ИИН',
				]);

				if (!$validator->fails()) {
					$iin = preg_replace('/[^0-9]/', '', $request->input('iin'));

					$result = file_get_contents('http://192.168.10.189/api/smartastana_pollingstation?iin=' . $iin);
					$result = json_decode($result);
				}else{
					$result = [
						'error' => null,
						'validator_iin' => [
							'iin' => $validator->errors()->first('iin')
						],
						'result' => null
					];
					$result = (object)$result;
				}

			} else {

					$validator = Validator::make($request->input(), [
						'name' => 'required',
						'surname' => 'required',
						'birthdate' => 'required',
					], [
						'name.required' => 'Имя не указано',
						'surname.required' => 'Фамилия не указана',
						'birthdate.required' => 'Дата рождения не указана',
					]);
					if (!$validator->fails()) {
						$result = file_get_contents('http://192.168.10.189/api/smartastana_pollingstation?name=' . $request->input('name') . '&surname=' . $request->input('surname') . '&patronymic=' . $request->input('patronymic') . '&birthdate=' . $date);
						$result = json_decode($result);
					}else{
						$result = [
							'error' => null,
							'validator_fio' => [
								'name' => $validator->errors()->first('name'),
								'surname' => $validator->errors()->first('surname'),
								'birthdate' => $validator->errors()->first('birthdate')
							],
							'result' => null
						];
						$result = (object)$result;
					}

			}

		}

		return view('site.templates.polling.short.default', [
			'result' => $result
		]);
	}
}
