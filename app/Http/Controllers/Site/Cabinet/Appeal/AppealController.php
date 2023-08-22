<?php

namespace App\Http\Controllers\Site\Cabinet\Appeal;

use App\Models\Appeal;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Validator;

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
        $validator = Validator::make($request->input(), ['date_from' => 'date','date_to' => 'date']);
        if (!$validator->fails()) {
            $request['date_from'] = Carbon::createFromDate(
                $request['date_from']
            )->format('d/m/Y');
            $request['date_to'] = Carbon::createFromDate(
                $request['date_to']
            )->format('d/m/Y');
        }
        unset($request['_token']);
        $pdf = Pdf::loadView(
            'appeals_pdf_templates.' . $request['appeal_chosen_view'],
            ['editing' => Appeal::STATUS['PRINT'], 'data' => $request->all()]
        );
        return $pdf->download('invoice.pdf');
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
