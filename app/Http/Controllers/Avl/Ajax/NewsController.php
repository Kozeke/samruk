<?php

namespace App\Http\Controllers\Avl\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\{Langs, News};
use Validator;
use Carbon\Carbon;

class NewsController extends AvlController
{

  public function changeNewsDate ($id, Request $request)
  {
      $record = News::findOrFail($id);

      $record->published_at = $request->input('published') . ':00';

      if ($record->save()) {
        return [
          'success' => ['Дата изменена'],
          'published' => date('Y-m-d H:i', strtotime($record->published_at)),
        ];
      }

      return ['errors' => ['Произошла ошибка']];
  }

	public function addSelectStructures ($areaId = 1)
	{
		$structures = getStructures(0, [], $areaId);

		return [
			'success' => true,
			'view' => view('avl.settings.sections.blocks.area-structures', [
				'areaStructures' => $structures,
				'parent' => 0,
				'current' => 0,
				'pre' => '',
				'level' => 0
			])->render()
		];
	}

}
