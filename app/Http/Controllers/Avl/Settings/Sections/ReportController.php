<?php

namespace App\Http\Controllers\Avl\Settings\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Avl\AvlController;
use App\Models\{Sections, Report};

class ReportController extends AvlController
{
    protected $langs = null;

    public function __construct (Request $request) {
      parent::__construct($request);
    }

    public function index($id)
    {
      $section = Sections::whereId($id)->where('area_id', $this->userArea)->firstOrFail();

      $this->authorize('update', $section);

      return view('avl.settings.sections.report.index', [
          'section' => $section,
          'reports' => Report::where('section_id', $section->id)->orderBy('id', 'asc')->paginate(30)
      ]);
    }

}
