<?php

namespace App\Http\Controllers\Site\Cabinet\Appeal;

use App\Models\Appeal;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Validator;
use DB;
/**
 * Class AppealController
 * @package App\Http\Controllers\Site\Cabinet\Appeal
 *
 * @author Kozy-Korpesh Tolep
 */
class AppealController extends Controller
{

    /**
     * @param Request $request
     * @return Response
     */
    public function downloadPdf(Request $request): Response
    {
        $validator = Validator::make($request->input(), ['date_from' => 'date', 'date_to' => 'date']);
        if (!$validator->fails()) {
            $request['date_from'] = Carbon::createFromDate(
                $request['date_from']
            )->format('d/m/Y');
            $request['date_to'] = Carbon::createFromDate(
                $request['date_to']
            )->format('d/m/Y');
        }
        unset($request['_token']);
        $appeal_view = DB::table('appeal_templates')->where('id', 1)->first(
        )->view_template_name;
        Pdf::setOptions(['dpi' => 150, 'defaultFont' => 'times_new_roman_cyr']);

        $pdf = PDF::loadView(
            'appeals_pdf_templates.partial_early_repayment_pdf',
            ['editing' => Appeal::STATUS['PRINT'], 'data' => $request->all()]
        )->setOptions(['fontDir' => '/public/site/fonts', 'defaultFont' => 'times_new_roman_cyr']);
        return $pdf->download("asd.pdf", 'F');
//        $options = new Options();
//        $options->set('defaultFont', 'times_new_roman_cyr');
//        $pdf = new Dompdf($options);
//        $pdf = new Dompdf(['fontDir' => '/public/site/fonts', 'defaultFont' => 'times_new_roman_cyr']);

        $nPageHTML = <<<HTML
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<style type="text/css">
@page{margin: 9mm 9mm 9mm 9mm;}
body{
	font-family: times_new_roman_cyr;
	font-size: 13px;
	line-height: 100%;
}
table{
	width: 100%;
	border-spacing: 1px;
	/* border: 1px solid black; */
}
td, th{
	/* padding: 1px; */
	/* border: 1px solid black; */
	vertical-align: top;
}
p{
	padding:0;
	margin:0;
}
.visibleBoard{
	border: 1px solid black;
}
.visibleBoard td,tr{
	border: 1px solid black;
	vertical-align: center;
}
</style>
</head>
<body>
<table>
    <tr>
		<td width="59%">
		<!-- таблица 1 левая часть -->
		<table>
			<tr>
				<td style="border-bottom: 2px solid black; text-align: left;">
					<div style="font-family: impact; font-size: 35px;"></div><br>
					<div style="font-family: verdana; font-size: 14px;"></div>
				</td>
			</tr>
			<tr>
				<td style="text-align: left;">
					<div><span style="font-weight: bolder;">asd применения</span></div>
					<br><div></div><br>
					<div><span style="font-weight: bolder;">Конструкция светильников</span></div>
					<br><div></div>
				</td>
			</tr>
		</table>
		</td>
		<td>
		<!-- таблица 2 -->
		<table style="text-align: center;">
			<tr>
				<td>
					<!-- <img width="240px" max-height="240px" src=""></br> -->
					<img style="width: auto; max-height: 240px;" src=""></br>
					<span style="font-weight: bolder;">Технические характеристики</span><br>
					<div class="visibleBoard"></div>
				</td>
			</tr>
			<tr>
				<td>
					<div style="">
					<br><span style="">Габаритные размеры</span><br>
					<img width="280px" max-height="115px" src="">
					</div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align="right" colspan="2">
			<div style="font-size:10px; color:gray;"><i>©2011- Мастер ЛЕД. Документ создан  в </i></div>
		</td>
	</tr>
</body>
</html>
HTML;
        $pdf->load_html($nPageHTML, 'UTF-8');
        $pdf->render();
//        return $pdf->stream("asd.pdf", ["Attachment" => 0]);
//        $this->saveAppeal(1, "path", $request['appeal_chosen_view']);
        return $pdf->stream('invoice.pdf');
    }

    /**
     * @return Factory|Application|View
     */
    public function index()
    {
        $appeals = Appeal::all()->keyBy('id');
        return view('appeals_pdf_templates.appeals', ['appeals' => $appeals]);
    }

    /**
     * @param Request $request
     * @return Factory|Application|View
     */
    public function getAppeal(Request $request)
    {
        $appeals = Appeal::all()->keyBy('id');
        $appeal_chosen_view = Appeal::find($request['chosen_appeal_id'])->view_template_name;
        return view(
            'appeals_pdf_templates.appeals',
            [
                'chosen_appeal_id' => $request['chosen_appeal_id'],
                'appeal_chosen_view' => $appeal_chosen_view,
                'appeals' => $appeals,
                'editing' => Appeal::STATUS['VIEW']
            ]
        );
    }

    public function getAppealHistory()
    {
        $values = AppealHistory::all();
        return view('appeals_pdf_templates.appeals-history', ['values' => $values]);
    }

    private function saveAppeal($id, $fullPathToTempPDF, $title)
    {
        AppealHistory::create([
            'user_id' => $id,
            'link' => $fullPathToTempPDF,
            'status' => AppealHistory::STATUS_SENT,
            'title' => $title,
//        'reply' =>
        ]);
    }

    /**
     * @param Request $request
     * @return Factory|Application|View
     */
    public function viewAppeal(Request $request)
    {
        if ($request['date_from']) {
            $request['date_from'] = Carbon::createFromFormat(
                'd/m/Y',
                $request['date_from']
            )->format('Y-m-d');
        }
        if ($request['date_to']) {
            $request['date_to'] = Carbon::createFromFormat(
                'd/m/Y',
                $request['date_to']
            )->format('Y-m-d');
        }
        unset($request['_token']);
        $appeals = Appeal::all()->keyBy('id');

        return view(
            'appeals_pdf_templates.appeals',
            [
                'chosen_appeal_id' => $request['chosen_appeal_id'],
                'appeal_chosen_view' => $request['appeal_chosen_view'],
                'data' => $request->all(),
                'appeals' => $appeals,
                'editing' => Appeal::STATUS['VIEW']
            ]
        );
    }

    /**
     * @param Request $request
     * @return Factory|Application|View
     */
    public function editAppeal(Request $request)
    {
        if ($request['date_from']) {
            $request['date_from'] = Carbon::createFromDate(
                $request['date_from']
            )->format('d/m/Y');
        }
        if ($request['date_to']) {
            $request['date_to'] = Carbon::createFromDate(
                $request['date_to']
            )->format('d/m/Y');
        }
        unset($request['_token']);
        $appeals = Appeal::all()->keyBy('id');
        return view(
            'appeals_pdf_templates.appeals',
            [
                'chosen_appeal_id' => $request['chosen_appeal_id'],
                'appeal_chosen_view' => $request['appeal_chosen_view'],
                'data' => $request->all(),
                'appeals' => $appeals,
                'editing' => Appeal::STATUS['EDIT']
            ]
        );
    }


}
