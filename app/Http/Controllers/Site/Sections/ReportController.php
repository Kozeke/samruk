<?php namespace App\Http\Controllers\Site\Sections;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\Sections\SectionsController;
use App\Models\{Sections, Report};
use Validator;
use App\Rules\RecaptchaRule;

class ReportController extends SectionsController
{

  public function index ()
  {
      $template = 'site.templates.report.full.' . $this->getTemplateFileName($this->section->current_template->file_full);

      return view($template, [
        'reports' => Report::whereAttend(1)->orderBy('id', 'asc')->limit(600)->get()
      ]);
  }

  public function store (Request $request)
  {
    $post = $request->input();

    $validator = Validator::make($post, [
      'fio' => 'required|max:255',
      'iin' => 'required|unique:report-meeting,iin|regex:/^[0-9]{12}$/',
      'contacts' => 'required',
      'location' => 'required',
      'direction' => 'required|not_in:0',
      'question' => 'required',
      'g-recaptcha-response' => [
        'required',
         new RecaptchaRule()
      ]
    ], trans('validation_forms.reports'));

    if (!$validator->fails()) {

      $attends = Report::whereAttend(1)->count();
      $report = new Report;

      $report->section_id = $this->section->id;
      $report->attend = ($attends < 600) ? 1 : 0;
      $report->fio = $post['fio'];
      $report->iin = $post['iin'];
      $report->contacts = $post['contacts'];
      $report->location = $post['location'];
      $report->direction = $post['direction'];
      $report->question = $post['question'];
      $report->ip = $request->ip();

      if ($report->save()) {
        return redirect()->back()->with([ 'success' => true ]);
      }

    }

    return redirect()->back()->withInput()->withErrors($validator);
  }
}
