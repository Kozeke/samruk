<?php namespace App\Http\Controllers\Site\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\Sections\SectionsController;
use App\Models\Sections;
use View;

class CalculatorController extends SectionsController
{
  public function index ()
  {
      return view('site.templates.calculator.full.default', [
        'complexes' => (isset($this->section->calculator)) ? $this->section->calculator : '',
      ]);
  }

}
