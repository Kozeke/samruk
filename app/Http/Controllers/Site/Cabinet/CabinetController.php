<?php

    namespace App\Http\Controllers\Site\Cabinet;

    use App\Exports\UsersExport;
    use App\Http\ApiRequest;
    use App\Http\Requests\SendAppealTemplateRequest;
    use App\Models\Appeal;
    use App\Models\AppealHistory;
    use App\Models\User;
    use App\Services\AppealService;
    use App\Services\KalkanCryptService;
    use Carbon\Carbon;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Site\BaseController;
    use Auth;
    use Illuminate\Support\Collection;
    use Maatwebsite\Excel\Facades\Excel;
    use Mail;
    use Symfony\Component\HttpFoundation\BinaryFileResponse;
    use Validator;
    use Illuminate\Support\Facades\App;
    use View;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use DB;

    /**
     *
     */
    class CabinetController extends BaseController
    {

        protected $section = [
            'name' => '',
            'type' => 'authorization',
            'configuration' => [
                'sidebar' => []
            ]
        ];

        // Показать блоки в колонке (алиас раздела в колонке)
        protected $sidebar = [
            "bastyk" => 1,
            "dev-projects" => 1,
            "ref-numbers" => 1,
            "population-figures" => 1,
            "right-banners" => 1,
            "population-figures" => 1,
            "mobile-apps-col" => 1,
        ];

        protected $api;

        protected $info;

        protected $mainInfo;

        protected $user;

        protected $data;

        /**
         * @var AppealService
         */
        private $appealService;
        /**
         * @var KalkanCryptService
         */
        private $kalkanCryptService;

        public function __construct(
            Request $request,
            ApiRequest $api,
            AppealService $appealService,
            KalkanCryptService $kalkanCryptService
        ) {
            $this->appealService = $appealService;
            $this->kalkanCryptService = $kalkanCryptService;
            $this->middleware(function ($request, $next) use ($api) {
                $this->user = Auth::user();
                $this->section['name'] = "Личная страница";
                // $this->section['name'] = trans('forms.auth.section_name');

                $section = json_decode(json_encode($this->section), false);

                $section->configuration->sidebar = $this->sidebar;

                $this->api = $api;
                $this->info = $this->api->CheckByInfoByClient([
                    "iin" => '900714350610',
//                    "num_phone" => $this->user->mobile,
                    "num_phone" => '+7 702 999 7002',
                    "date_zp" => Carbon::now()->format('YmdHis')
                ])->_toArray();
                $this->info = [
                    "code" => 200,
                    "data" => [
                        "result" => "0",
                        "comment" => "Ok!",
                        "FIO" => "Садубаев Адилбек",
                        "mail" => [],
                        "Num_d" => [
                            "number" => "301200241",
                            "date_d" => "15.06.2023 0:00:00",
                            "JK" => "ЖК по улице Улы Дала, дом 17",
                            "AdressJK" => "Проспект Улы Дала 17",
                            "Korpus" => [],
                            "Dom" => "_",
                            "Number_room" => "Квартира №32, дом №17/1, этаж 7, 66,7 кв.м.",
                            "gar_plat_by_dog" => [],
                            "sum_d" => "1 166 667",
                            "plat_d" => "0",
                            "plat_date" => [],
                            "zad_plat" => "0",
                            "penya" => "0",
                            "gar_plat" => "0",
                            "im_nalog" => "0",
                        ]
                    ]
                ];
                if ($this->info['code'] == 200) {
                    $this->data = $this->info['data'];
                    if ($this->data['result'] == 1) {
                        $this->data = [
                            'code' => 404,
                            'message' => 'Невозможно получить информацию так как в базе отсутсвует номер телефона',
                            'Num_d' => 0
                        ];
                    } elseif ($this->data['result'] == 0) {
                        $this->data = [
                            'code' => 200,
                            'message' => 'good',
                            'Num_d' => $this->info['data']['Num_d']
                        ];
                    } else {
                        $this->data = [
                            'code' => 404,
                            'message' => 'Не найдет абонент с таким ИИН в базе'
                        ];
                    }
                } else {
                    $this->data = [
                        'code' => 500,
                        'message' => 'Ошибка связи с сервером попробуйте позднее'
                    ];
                }

                View::share([
                    'indexPage' => false,
                    'pagination' => null,
                    'section' => $section,
                    'extends' => 'site.templates.pages',
                    'settings' => [
                        'description' => '',
                        'keywords' => '',
                        'title' => 'АО "Samruk-Kazyna Construction"',
                        // 'title' => trans('translations.siteName'),
                    ],
                    'breadcrumbs' => [
                        0 => [
                            "link" => '/auth',
                            "name" => "Вход в личный кабинет"
                            // "name" => trans('forms.auth.section_name')
                        ]
                    ]
                ]);
                return $next($request);
            });

            parent::__construct($request);
        }


        public function index()
        {
            $data = $this->data;
            if (isset($data)) {
                $dogovor = $data['Num_d'];

                if (!isset($dogovor[0]['number'])) {
                    $dogovor = [];
                    $dogovor[] = $data['Num_d'];
                }
            }
//        $notifications = $this->api->CheckInfo([
//            "iin" => $this->user->iin,
//            "num_phone" => $this->user->mobile,
//            "num_d" => $dogovor[0]['number'],
//            "date_zp" => Carbon::now()->format('YmdHis')
//        ])->_toArray();
//        $mainInfo = $this->api->CheckMainInfo([
//            "iin" => $this->user->iin,
//            "num_phone" => $this->user->mobile,
//            "date_zp" => Carbon::now()->format('YmdHis'),
//            "num_d" => $id
//        ])->_toArray();
            $mainInfo = [
                "code" => 200,
                "data" => [
                    "result" => "0",
                    "comment" => [],
                    "FIO" => "Садубаев Адилбек",
                    "num_d" => "301200241",
                    "gar_plat_perep" => "0",
                    "gar_plat_dolg" => "0",
                    "plat_perep" => "0",
                    "plat_dolg" => "0",
                    "im_nalog_perep" => "0",
                    "im_nalog_dolg" => "0",
                    "penya_gp_perep" => "0",
                    "penya_gp_dolg" => "0",
                    "penya_ap_perep" => "0",
                    "penya_ap_dolg" => "0",
                    "data_d" => "15.06.2023 0:00:00"
                ]
            ];
            return view('site.cabinet.index', [
                'user' => $this->user,
                'data' => $this->data,
                'dogovor' => $dogovor,
//            'notifications' => $notifications,
                'indexPage' => false,
                'dontShowNotification' => true,
                'mainInfo' => $mainInfo,
                'profile_check_need' => $this->user->profileCheckWasMadeBeforeTwoMonths()
            ]);
        }

        public function show($id)
        {
            $notifications = $this->api->CheckInfo([
                "iin" => $this->user->iin,
                "num_phone" => $this->user->mobile,
                "num_d" => $id,
                "date_zp" => Carbon::now()->format('YmdHis')
            ])->_toArray();

//        $mainInfo = $this->api->CheckMainInfo([
//            "iin" => $this->user->iin,
//            "num_phone" => $this->user->mobile,
//            "date_zp" => Carbon::now()->format('YmdHis'),
//            "num_d" => $id
//        ])->_toArray();
            $mainInfo = [
                "code" => 200,
                "data" => [
                    "result" => "0",
                    "comment" => [],
                    "FIO" => "Садубаев Адилбек",
                    "num_d" => "301200241",
                    "gar_plat_perep" => "0",
                    "gar_plat_dolg" => "0",
                    "plat_perep" => "0",
                    "plat_dolg" => "0",
                    "im_nalog_perep" => "0",
                    "im_nalog_dolg" => "0",
                    "penya_gp_perep" => "0",
                    "penya_gp_dolg" => "0",
                    "penya_ap_perep" => "0",
                    "penya_ap_dolg" => "0",
                    "data_d" => "15.06.2023 0:00:00"
                ]
            ];
            $spisanie_s_gp = null;
            if (isset($notifications['data']['spisanie_s_gp']['gp'])) {
                $spisanie_s_gp = $notifications['data']['spisanie_s_gp']['gp'];

                if (!isset($spisanie_s_gp[0]['date_sp'])) {
                    $spisanie_s_gp = [];
                    $spisanie_s_gp[] = $notifications['data']['spisanie_s_gp']['gp'];
                }
            }

            $data = $this->data;
            if (isset($data)) {
                $dogovor = $data['Num_d'];

                if (!isset($dogovor[0]['number'])) {
                    $dogovor = [];
                    $dogovor[] = $data['Num_d'];
                }
            }

            $collect = collect($dogovor);
            $data = $collect->where('number', $id)->toArray();
            $data = array_values($data);

            return view('site.cabinet.show', [
                'user' => $this->user,
                'data' => $data[0],
                'mainInfo' => $mainInfo,
                'id' => $id,
                'notifications' => $notifications,
                'spisanie_s_gp' => $spisanie_s_gp,
                'indexPage' => false
            ]);
        }

        public function CheckGrafic($num_d)
        {
            $api = new ApiRequest();

            $info = $api->Checkgrafic([
                "iin" => $this->user->iin,
                "Num_d" => $num_d,
                "date_zp" => Carbon::now()->format('YmdHis')
            ])->_toArray();

            if ($info['code'] == 200) {
                $grafic = $info['data'];
                if ($grafic['result'] == 1) {
                    $grafic = [
                        'code' => 404,
                        'message' => 'Невозможно получить информацию так как в базе отсутсвует номер телефона'
                    ];
                } elseif ($grafic['result'] == 0) {
                    if (isset($info['data']['plateg']) && !empty($info['data']['plateg'])) {
                        $grafic = [
                            'code' => 200,
                            'message' => 'good',
                            'plateg' => $info['data']['plateg']
                        ];
                    } else {
                        $grafic = [
                            'code' => 404,
                            'message' => 'Не найдены данные в базе'
                        ];
                    }
                } else {
                    $grafic = [
                        'code' => 404,
                        'message' => 'Не найдет абонент с таким ИИН в базе'
                    ];
                }
            } else {
                $grafic = [
                    'code' => 500,
                    'message' => 'Ошибка связи с сервером попробуйте позднее'
                ];
            }

            $data = $this->data;
            if (isset($data)) {
                $dogovor = $data['Num_d'];

                if (!isset($dogovor[0]['number'])) {
                    $dogovor = [];
                    $dogovor[] = $data['Num_d'];
                }
            }

            $collect = collect($dogovor);
            $data = $collect->where('number', $num_d)->toArray();
            $data = array_values($data);

            return view('site.cabinet.check_grafic', [
                'user' => $this->user,
                'id' => $num_d,
                'data' => $data[0],
                'grafic' => $grafic,
                'indexPage' => false
            ]);
        }

        public function GraficPDF($num_d)
        {
            $api = new ApiRequest();

            $info = $api->Checkgrafic([
                "iin" => $this->user->iin,
                "Num_d" => $num_d,
                "date_zp" => Carbon::now()->format('YmdHis')
            ])->_toArray();

            $grafic = $info['data'];

            $html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
            $html = '
         <style>
            @font-face {
              font-family: "DejaVu Sans";
              font-style: normal;
              font-weight: 400;
              src: url("/fonts/dejavu-sans/DejaVuSans.ttf");
              /* IE9 Compat Modes */
              src:
                local("DejaVu Sans"),
                local("DejaVu Sans"),
                url("/fonts/dejavu-sans/DejaVuSans.ttf") format("truetype");
            }
            body {
              font-family: "DejaVu Sans";
              font-size: 12px;
            }

            table,
            table td,
            table th {
             border:1px solid #c4c4c4;
             border-collapse:collapse
            }
            table {
             max-width:100%;
             margin-bottom:1em
            }
            table td,
            table th {
             padding:.66666667em .8em
            }
          </style>';
            $html .= '<table>';
            $html .= '<thead>';
            $html .= '<tr class="text-center">';
            $html .= '<th>#</th>';
            $html .= '<th>Дата платежа</th>';
            $html .= '<th>Сумма платежа</th>';
            $html .= '<th>Основной долг</th>';
            $html .= '<th>Вознаграждение</th>';
            $html .= '<th>Остаток основного долга</th>';
            $html .= '<th>Цена продажи помещения, тенге</th>';
            if ($grafic['plateg'][0]['NDS'] != 0) {
                $html .= '<th>НДС</th>';
            }
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            $i = 1;
            foreach ($grafic['plateg'] as $plateg) {
                $html .= '<tr>';
                $html .= '<td>' . $i . '</td>';
                $html .= '<td>' . substr($plateg["ДатаПлатежа"], 0, 10) . '</td>';
                $html .= '<td>' . $plateg["platesh"] . '</td>';
                $html .= '<td>' . $plateg["osn_dolg"] . '</td>';
                $html .= '<td>' . $plateg["Vozn"] . '</td>';
                $html .= '<td>' . $plateg["Ost_osn_dolg"] . '</td>';
                $html .= '<td>' . $plateg["Ost_plateg"] . '</td>';
                if ($grafic['plateg'][0]['NDS'] != 0) {
                    $html .= '<td>' . $plateg["NDS"] . '</td>';
                }
                $html .= '</tr>';
                $i++;
            }

            $html .= '</tbody>';
            $html .= '</table>';

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($html);
            return $pdf->stream();
        }

        public function CheckAkt($num_d)
        {
            $akt = $this->api->CheckAkt([
                "iin" => $this->user->iin,
                "Num_d" => $num_d,
                "date_akt" => Carbon::now()->format('YmdHis')
            ])->_toArray();

            $xlsx_file = \PhpOffice\PhpSpreadsheet\IOFactory::load(
                public_path("excel/akt_cabinet_07.02.2020_new_1.3.xlsx")
            );

            $xlsx_file->setActiveSheetIndex(0);
            // Получаем активный лист
            $sheet = $xlsx_file->getActiveSheet();

            $style = array(
                'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                )
            );

            $border = array(
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            );

            $bold = array(
                'font' => [
                    'bold' => true,
                ],
            );

            $sheet->mergeCells("A1:F1");
            $sheet->setCellValue("A1", ' Справка мониторинга ');

            $sheet->mergeCells("A2:F2");
            $sheet->setCellValue("A2", ' Период запроса : ' . $akt['data']['date_d'] . ' ');

            $sheet->mergeCells("C4:D4");
            $sheet->mergeCells("E4:F4");

            $sheet->setCellValue("A4", ' Договор ');
            $sheet->getStyle("A4")->applyFromArray($border);
            $sheet->setCellValue("B4", ' Дата подписания ');
            $sheet->getStyle("B4")->applyFromArray($border);
            $sheet->setCellValue("C4", ' ФИО ');
            $sheet->getStyle("C4:D4")->applyFromArray($border);
            $sheet->setCellValue("E4", ' Адрес ');
            $sheet->getStyle("E4:F4")->applyFromArray($border);
            $sheet->getStyle("E5:F5")->applyFromArray($border);

            $sheet->mergeCells("C5:D5");
            $sheet->mergeCells("E5:F5");

            if (isset($akt['data']['num_d'])) {
                $sheet->getStyle("A5")->applyFromArray($border);
                $sheet->setCellValue("A5", ' ' . $akt['data']['num_d'] . ' ');
            }

            if (isset($akt['data']['date_d']) && !empty($akt['data']['date_d'])) {
                $sheet->getStyle("B5")->applyFromArray($border);
                $sheet->setCellValue("B5", ' ' . $akt['data']['date_d'] . ' ');
            }

            if (isset($akt['data']['FIO'])) {
                $sheet->getStyle("C5:D5")->applyFromArray($border);
                $sheet->setCellValue("C5", ' ' . $akt['data']['FIO'] . ' ');
            }
            if (isset($akt['data']['address'])) {
                $sheet->getStyle("E5:F5")->applyFromArray($border);
                $sheet->setCellValue("E5", ' ' . $akt['data']['address'] . ' ');
            }

            $sheet->mergeCells("A7:C7");
            $sheet->setCellValue("A7", "Первоначальный взнос");
            $sheet->getStyle("A7:C7")->applyFromArray($border);
            $sheet->getStyle("A7:C7")->applyFromArray($bold);

            $sheet->setCellValue("A8", "По договору");
            $sheet->getStyle("A8")->applyFromArray($border);
            $sheet->setCellValue("B8", "Дата оплаты");
            $sheet->getStyle("B8")->applyFromArray($border);
            $sheet->setCellValue("C8", "Фактически поступило");
            $sheet->getStyle("C8")->applyFromArray($border);
            $sheet->getStyle("A9")->applyFromArray($border);
            $sheet->getStyle("B9")->applyFromArray($border);
            $sheet->getStyle("C9")->applyFromArray($border);
            $sheet->getStyle("A10")->applyFromArray($border);
            $sheet->getStyle("B10")->applyFromArray($border);
            $sheet->getStyle("C10")->applyFromArray($border);
            $sheet->setCellValue("A10", ' ИТОГО: ');

            if (!empty($akt['data']['TZ_per_vznos'])) {
                $sheet->setCellValue("A9", ' ' . $akt['data']['TZ_per_vznos']['vznos']['nach'] . ' ');
                $sheet->setCellValue("B9", ' ' . $akt['data']['TZ_per_vznos']['vznos']['date_oplata'] . ' ');
                $sheet->setCellValue("C9", ' ' . $akt['data']['TZ_per_vznos']['vznos']['oplacheno'] . ' ');
                $sheet->setCellValue("C10", ' ' . $akt['data']['TZ_per_vznos']['vznos']['Itog_PV'] . ' ');
            }

            $sheet->mergeCells("A12:B12");
            $sheet->getStyle("A12")->applyFromArray($border);
            $sheet->getStyle("B12")->applyFromArray($border);
            $sheet->mergeCells("C12:D12");
            $sheet->getStyle("C12")->applyFromArray($border);
            $sheet->getStyle("D12")->applyFromArray($border);
            $sheet->setCellValue("A12", ' Гарантийный платеж по Договору ');

            if (isset($akt['data']['gv_by_dogovor'])) {
                $sheet->setCellValue("C12", ' ' . $akt['data']['gv_by_dogovor'] . ' ');
            }

            $sheet->getStyle("A13")->applyFromArray($border);
            $sheet->getStyle("B13")->applyFromArray($border);
            $sheet->getStyle("C13")->applyFromArray($border);
            $sheet->getStyle("D13")->applyFromArray($border);
            $sheet->getStyle("A13")->applyFromArray($bold);
            $sheet->mergeCells("A13:D13");
            $sheet->setCellValue("A13", ' Гарантийный платеж ');

            $sheet->mergeCells("A14:B14");
            $sheet->getStyle("A14")->applyFromArray($border);
            $sheet->getStyle("B14")->applyFromArray($border);
            $sheet->setCellValue("A14", ' Списано ');
            $sheet->getStyle("C14")->applyFromArray($border);
            $sheet->getStyle("D14")->applyFromArray($border);
            $sheet->mergeCells("C14:D14");
            $sheet->setCellValue("C14", ' Пополнение ');

            $row = 15;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' Дата ');
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->setCellValue("B" . $row, ' Сумма ');
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->setCellValue("C" . $row, ' Дата ');
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->setCellValue("D" . $row, ' Сумма ');
            $row++;

            if (!empty($akt['data']['TZ_gar_vznos'])) {
                $vznos = $akt['data']['TZ_gar_vznos']['vznos'];

                if (!isset($vznos[0]['gp_spis_date'])) {
                    $vznos = [];
                    $vznos[] = $akt['data']['TZ_gar_vznos']['vznos'];
                }

                if (count($vznos) > 0) {
                    foreach ($vznos as $garant) {
                        $sheet->getStyle("A" . $row)->applyFromArray($border);
                        $sheet->getStyle("B" . $row)->applyFromArray($border);
                        $sheet->getStyle("C" . $row)->applyFromArray($border);
                        $sheet->getStyle("D" . $row)->applyFromArray($border);
                        if (!empty($garant['gp_spis_date'])) {
                            $sheet->setCellValue(
                                "A" . $row,
                                ' ' . Carbon::parse($garant['gp_spis_date'])->format('d.m.Y') . ' '
                            );
                        }
                        if (isset($garant['gp_spis_sum'])) {
                            $sheet->setCellValue("B" . $row, ' ' . $garant['gp_spis_sum'] . ' ');
                        }
                        if (!empty($garant['gp_pop_date'])) {
                            $sheet->setCellValue(
                                "C" . $row,
                                ' ' . Carbon::parse($garant['gp_pop_date'])->format('d.m.Y') . ' '
                            );
                        }
                        if (isset($garant['gp_pop_sum'])) {
                            $sheet->setCellValue("D" . $row, ' ' . $garant['gp_pop_sum'] . ' ');
                        }
                        $row++;
                    }
                }
            }
            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' ИТОГО: ');
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            if (isset($akt['data']['itog_gp_spis'])) {
                $sheet->setCellValue("B" . $row, ' ' . $akt['data']['itog_gp_spis'] . ' ');
            }
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            if (isset($akt['data']['itog_gp_pop'])) {
                $sheet->setCellValue("D" . $row, ' ' . $akt['data']['itog_gp_pop'] . ' ');
            }
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' Остаток на ГП: ');
            $sheet->mergeCells("C" . $row . ":D" . $row);
            if (isset($akt['data']['ostatok_gp'])) {
                $sheet->setCellValue("C" . $row, ' ' . $akt['data']['ostatok_gp'] . ' ');
            }

            $row++;
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $sheet->getStyle("A" . $row)->applyFromArray($bold);
            $sheet->mergeCells("A" . $row . ":E" . $row);
            $sheet->setCellValue("A" . $row, ' Пеня по гарантийному платежу ');
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' Дата ');
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->setCellValue("B" . $row, ' Кол-во просроченных дней ');
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->setCellValue("C" . $row, ' Начислено ');
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->setCellValue("D" . $row, ' Дата оплаты ');
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $sheet->setCellValue("E" . $row, ' Погашено ');
            $row++;

            if (!empty($akt['data']['GP_penya'])) {
                $penya = $akt['data']['GP_penya']['plateg'];

                if (!isset($penya[0]['date_p'])) {
                    $penya = [];
                    $penya[] = $akt['data']['GP_penya']['plateg'];
                }
                if (count($penya) > 0) {
                    foreach ($penya as $penya_row) {
                        $sheet->getStyle("A" . $row)->applyFromArray($border);
                        $sheet->getStyle("B" . $row)->applyFromArray($border);
                        $sheet->getStyle("C" . $row)->applyFromArray($border);
                        $sheet->getStyle("D" . $row)->applyFromArray($border);
                        $sheet->getStyle("E" . $row)->applyFromArray($border);
                        if (!empty($penya_row['date_p'])) {
                            $sheet->setCellValue(
                                "A" . $row,
                                ' ' . Carbon::parse($penya_row['date_p'])->format('d.m.Y') . ' '
                            );
                        }
                        if (isset($penya_row['kol_days'])) {
                            $sheet->setCellValue("B" . $row, ' ' . $penya_row['kol_days'] . ' ');
                        }
                        if (isset($penya_row['nach'])) {
                            $sheet->setCellValue("C" . $row, ' ' . $penya_row['nach'] . ' ');
                        }
                        if (!empty($penya_row['date_opl'])) {
                            $sheet->setCellValue(
                                "D" . $row,
                                ' ' . Carbon::parse($penya_row['date_opl'])->format('d.m.Y') . ' '
                            );
                        }
                        if (!empty($penya_row['pogasheno'])) {
                            $sheet->setCellValue("E" . $row, ' ' . $penya_row['pogasheno'] . ' ');
                        }
                        $row++;
                    }
                }
            }

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' ИТОГО: ');

            if (isset($akt['data']['itog_penya_nach'])) {
                $sheet->setCellValue("C" . $row, ' ' . $akt['data']['itog_penya_nach'] . ' ');
            }
            if (isset($akt['data']['itog_penya_pog'])) {
                $sheet->setCellValue("E" . $row, ' ' . $akt['data']['itog_penya_pog'] . ' ');
            }
            $row++;
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $sheet->getStyle("A" . $row)->applyFromArray($bold);
            $sheet->mergeCells("A" . $row . ":E" . $row);
            $sheet->setCellValue("A" . $row, ' Арендный платеж ');
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $sheet->getStyle("F" . $row)->applyFromArray($border);
            $sheet->getStyle("G" . $row)->applyFromArray($border);
            $sheet->getStyle("H" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' Период ');
            $sheet->setCellValue("B" . $row, ' Контрольная дата погашения ');
            $sheet->setCellValue("C" . $row, ' Начислено по графику ');
            $sheet->setCellValue("D" . $row, ' Дата оплаты ');
            $sheet->setCellValue("E" . $row, ' Погашено ');
            $sheet->setCellValue("F" . $row, ' Списано ');
            $sheet->setCellValue("G" . $row, ' НДС ');
            $sheet->setCellValue("H" . $row, ' Сумма без НДС ');
            $row++;

            if (isset($akt['data']['TZ_AP']['plateg'])) {
                $plateg = $akt['data']['TZ_AP']['plateg'];

                if (!isset($plateg[0]['nom_pp'])) {
                    $plateg = [];
                    $plateg[] = $akt['data']['TZ_AP']['plateg'];
                }

                if (count($plateg) > 0) {
                    foreach ($plateg as $plateg_row) {
                        $sheet->getStyle("A" . $row)->applyFromArray($border);
                        $sheet->getStyle("B" . $row)->applyFromArray($border);
                        $sheet->getStyle("C" . $row)->applyFromArray($border);
                        $sheet->getStyle("D" . $row)->applyFromArray($border);
                        $sheet->getStyle("E" . $row)->applyFromArray($border);
                        $sheet->getStyle("F" . $row)->applyFromArray($border);
                        $sheet->getStyle("G" . $row)->applyFromArray($border);
                        $sheet->getStyle("H" . $row)->applyFromArray($border);
                        if (isset($plateg_row['nom_pp'])) {
                            $sheet->setCellValue("A" . $row, ' ' . $plateg_row['nom_pp'] . ' ');
                        }
                        if (!empty($plateg_row['period'])) {
                            $sheet->setCellValue(
                                "B" . $row,
                                ' ' . Carbon::parse($plateg_row['period'])->format('d.m.Y') . ' '
                            );
                        }
                        if (isset($plateg_row['nach'])) {
                            $sheet->setCellValue("C" . $row, ' ' . $plateg_row['nach'] . ' ');
                        }
                        if (!empty($plateg_row['date_pl'])) {
                            $sheet->setCellValue(
                                "D" . $row,
                                ' ' . Carbon::parse($plateg_row['date_pl'])->format('d.m.Y') . ' '
                            );
                        }
                        if (isset($plateg_row['pogasheno'])) {
                            $sheet->setCellValue("E" . $row, ' ' . $plateg_row['pogasheno'] . ' ');
                        }
                        if (isset($plateg_row['spisano'])) {
                            $sheet->setCellValue("F" . $row, ' ' . $plateg_row['spisano'] . ' ');
                        }
                        if (isset($plateg_row['NDS'])) {
                            $sheet->setCellValue("G" . $row, ' ' . $plateg_row['NDS'] . ' ');
                        }
                        if (isset($plateg_row['SummaBezNDS'])) {
                            $sheet->setCellValue("H" . $row, ' ' . $plateg_row['SummaBezNDS'] . ' ');
                        }
                        $row++;
                    }
                }
            }
            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $sheet->getStyle("F" . $row)->applyFromArray($border);
            $sheet->getStyle("G" . $row)->applyFromArray($border);
            $sheet->getStyle("H" . $row)->applyFromArray($border);
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $sheet->getStyle("F" . $row)->applyFromArray($border);
            $sheet->getStyle("G" . $row)->applyFromArray($border);
            $sheet->getStyle("H" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' ИТОГО: ');

            if (isset($akt['data']['itog_nach_AP'])) {
                $sheet->setCellValue("C" . $row, ' ' . $akt['data']['itog_nach_AP'] . ' ');
            }
            if (isset($akt['data']['itog_pog_AP'])) {
                $sheet->setCellValue("E" . $row, ' ' . $akt['data']['itog_pog_AP'] . ' ');
            }
            if (isset($akt['data']['itog_spis_AP'])) {
                $sheet->setCellValue("F" . $row, ' ' . $akt['data']['itog_spis_AP'] . ' ');
            }
            if (isset($akt['data']['itog_NDS_AP'])) {
                $sheet->setCellValue("G" . $row, ' ' . $akt['data']['itog_NDS_AP'] . ' ');
            }
            if (isset($akt['data']['itog_SumBezNDS_AP'])) {
                $sheet->setCellValue("H" . $row, ' ' . $akt['data']['itog_SumBezNDS_AP'] . ' ');
            }
            $row++;
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $sheet->getStyle("A" . $row)->applyFromArray($bold);
            $sheet->mergeCells("A" . $row . ":E" . $row);
            $sheet->setCellValue("A" . $row, ' Пеня по арендному платежу ');
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' Дата ');
            $sheet->setCellValue("B" . $row, ' Кол-во ');
            $sheet->setCellValue("C" . $row, ' Начислено ');
            $sheet->setCellValue("D" . $row, ' Дата оплаты ');
            $sheet->setCellValue("E" . $row, ' Погашено ');
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' ИТОГО: ');

            if (isset($akt['data']['itog_nach_penya'])) {
                $sheet->setCellValue("C" . $row, ' ' . $akt['data']['itog_nach_penya'] . ' ');
            }
            if (isset($akt['data']['itog_pog_penya'])) {
                $sheet->setCellValue("E" . $row, ' ' . $akt['data']['itog_pog_penya'] . ' ');
            }
            $row++;
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("A" . $row)->applyFromArray($bold);
            $sheet->mergeCells("A" . $row . ":E" . $row);
            $sheet->setCellValue("A" . $row, ' Возмещение налога на имущество ');
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' Период начисления ');
            $sheet->setCellValue("B" . $row, ' Начислено ');
            $sheet->setCellValue("C" . $row, ' Дата оплаты ');
            $sheet->setCellValue("D" . $row, ' Погашено ');
            $sheet->setCellValue("E" . $row, ' Списано ');
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' ИТОГО: ');

            if (isset($akt['data']['itog_nach_nalog'])) {
                $sheet->setCellValue("B" . $row, ' ' . $akt['data']['itog_nach_nalog'] . ' ');
            }
            if (isset($akt['data']['itog_pog_nalog'])) {
                $sheet->setCellValue("D" . $row, ' ' . $akt['data']['itog_pog_nalog'] . ' ');
            }
            if (isset($akt['data']['itog_spis_nalog'])) {
                $sheet->setCellValue("E" . $row, ' ' . $akt['data']['itog_spis_nalog'] . ' ');
            }
            $row++;
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("A" . $row)->applyFromArray($bold);
            $sheet->mergeCells("A" . $row . ":D" . $row);
            $sheet->setCellValue("A" . $row, ' Иные списания ');
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->mergeCells("C" . $row . ":D" . $row);
            $sheet->setCellValue("A" . $row, ' Дата списания ');
            $sheet->setCellValue("B" . $row, ' Сумма списания ');
            $sheet->setCellValue("C" . $row, ' Назначение ');
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' ИТОГО: ');

            if (isset($akt['data']['itog_dr_spis'])) {
                $sheet->setCellValue("B" . $row, ' ' . $akt['data']['itog_dr_spis'] . ' ');
            }

            $row++;
            $row++;


            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("A" . $row)->applyFromArray($bold);
            $sheet->mergeCells("A" . $row . ":D" . $row);
            $sheet->setCellValue("A" . $row, ' Частично-досрочное погашение ');
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' Дата оплаты ');
            $sheet->setCellValue("B" . $row, ' Фактически оплачено ');
            $sheet->setCellValue("C" . $row, ' Погашено ');
            $sheet->setCellValue("D" . $row, ' Сумма возврата Арендатору/Отбасы Банк ');
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' ИТОГО: ');

            if (isset($akt['data']['itog_fakt_chdp'])) {
                $sheet->setCellValue("B" . $row, ' ' . $akt['data']['itog_fakt_chdp'] . ' ');
            }
            if (isset($akt['data']['itog_chdp'])) {
                $sheet->setCellValue("C" . $row, ' ' . $akt['data']['itog_chdp'] . ' ');
            }
            if (isset($akt['data']['itog_vozv_chdp'])) {
                $sheet->setCellValue("D" . $row, ' ' . $akt['data']['itog_vozv_chdp'] . ' ');
            }
            $row++;
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("A" . $row)->applyFromArray($bold);
            $sheet->mergeCells("A" . $row . ":D" . $row);
            $sheet->setCellValue("A" . $row, ' Полное досрочное погашение ');
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' Дата оплаты ');
            $sheet->setCellValue("B" . $row, ' Фактически оплачено ');
            $sheet->setCellValue("C" . $row, ' Погашено ');
            $sheet->setCellValue("D" . $row, ' Сумма возврата Арендатору/Отбасы Банк ');
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' ИТОГО: ');

            if (isset($akt['data']['itog_fakt_PDP'])) {
                $sheet->setCellValue("B" . $row, ' ' . $akt['data']['itog_fakt_PDP'] . ' ');
            }
            if (isset($akt['data']['itog_PDP'])) {
                $sheet->setCellValue("C" . $row, ' ' . $akt['data']['itog_PDP'] . ' ');
            }
            if (isset($akt['data']['itog_vozv_PDP'])) {
                $sheet->setCellValue("D" . $row, ' ' . $akt['data']['itog_vozv_PDP'] . ' ');
            }
            $row++;
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->getStyle("C" . $row)->applyFromArray($border);
            $sheet->getStyle("D" . $row)->applyFromArray($border);
            $sheet->getStyle("E" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, '  ');
            $sheet->setCellValue("B" . $row, ' Всего начислено ');
            $sheet->setCellValue("C" . $row, ' Всего погашено ');
            $sheet->setCellValue("D" . $row, ' Переплата ');
            $sheet->setCellValue("E" . $row, ' Долг ');
            $row++;

            if (isset($akt['data']['TZ_itog'])) {
                $itog = $akt['data']['TZ_itog']['plateg'];

                if (!isset($itog[0]['vid_plateg'])) {
                    $itog = [];
                    $itog[] = $akt['data']['TZ_itog']['plateg'];
                }

                if (count($itog) > 0) {
                    foreach ($itog as $itog_row) {
                        $sheet->getStyle("A" . $row)->applyFromArray($border);
                        $sheet->getStyle("B" . $row)->applyFromArray($border);
                        $sheet->getStyle("C" . $row)->applyFromArray($border);
                        $sheet->getStyle("D" . $row)->applyFromArray($border);
                        $sheet->getStyle("E" . $row)->applyFromArray($border);
                        if (isset($itog_row['vid_plateg'])) {
                            $sheet->setCellValue("A" . $row, ' ' . $itog_row['vid_plateg'] . ' ');
                        }
                        if (isset($itog_row['nach']) && !empty($itog_row['nach'])) {
                            $sheet->setCellValue("B" . $row, ' ' . $itog_row['nach'] . ' ');
                        }
                        if (isset($itog_row['pogash']) && !empty($itog_row['pogash'])) {
                            $sheet->setCellValue("C" . $row, ' ' . $itog_row['pogash'] . ' ');
                        }
                        if (isset($itog_row['pereplata']) && !empty($itog_row['pereplata'])) {
                            $sheet->setCellValue("D" . $row, ' ' . $itog_row['pereplata'] . ' ');
                        }
                        if (isset($itog_row['dolg']) && !empty($itog_row['dolg'])) {
                            $sheet->setCellValue("E" . $row, ' ' . $itog_row['dolg'] . ' ');
                        }
                        $row++;
                    }
                }
            }

            $row++;
            $row++;

            $sheet->getStyle("A" . $row)->applyFromArray($border);
            $sheet->getStyle("B" . $row)->applyFromArray($border);
            $sheet->setCellValue("A" . $row, ' Остаток гарантийного платежа ');

            if (isset($akt['data']['Itog_GP'])) {
                $sheet->setCellValue("B" . $row, ' ' . $akt['data']['Itog_GP'] . ' ');
            }


            $sheet->getStyle("A1:A" . $row)->applyFromArray($style);
            $sheet->getStyle("B1:B" . $row)->applyFromArray($style);
            $sheet->getStyle("C1:C" . $row)->applyFromArray($style);
            $sheet->getStyle("D1:D" . $row)->applyFromArray($style);
            $sheet->getStyle("E1:E" . $row)->applyFromArray($style);
            $sheet->getStyle("F1:F" . $row)->applyFromArray($style);
            $sheet->getStyle("G1:G" . $row)->applyFromArray($style);
            $sheet->getStyle("H1:H" . $row)->applyFromArray($style);

            $writer = new Xlsx($xlsx_file);

            $writer->save(public_path("excel/akt_cabinet" . $num_d . ".xlsx"));


            return response()->download(public_path("excel/akt_cabinet" . $num_d . ".xlsx"));

            File::delete(public_path("excel/akt_cabinet" . $num_d . ".xlsx"));
        }

        public function settings()
        {
            $data = $this->data;
            if (isset($data)) {
                $dogovor = $data['Num_d'];

                if (!isset($dogovor[0]['number'])) {
                    $dogovor = [];
                    $dogovor[] = $data['Num_d'];
                }
            }

//        $collect = collect($dogovor);
//        $data = $collect->where('number', $num_d)->toArray();
//        $data = array_values($data);

            return view('site.cabinet.settings', [
                'indexPage' => false,
                'user' => $this->user,
//            'data' => $data[0],
//            'id' => $num_d,
                'success' => false,
                'settingsPage' => true,
            ]);
        }

        public function faq()
        {
            $data = $this->data;
            if (isset($data)) {
                $dogovor = $data['Num_d'];

                if (!isset($dogovor[0]['number'])) {
                    $dogovor = [];
                    $dogovor[] = $data['Num_d'];
                }
            }

//        $collect = collect($dogovor);
//        $data = $collect->where('number', $num_d)->toArray();
//        $data = array_values($data);

            return view('site.cabinet.faq', [
                'indexPage' => false,
                'user' => $this->user,
//            'data' => $data[0],
//            'id' => $num_d,
                'success' => false,
                'faqPage' => true,
                'records' => new Collection,
            ]);
        }

        public function save_pass(Request $request)
        {
            $post = $this->validate(request(), [
                'password' => 'required|min:5|max:200',
                'confirm' => 'required|same:password',
            ]);

            $user = $this->user;

//        $collect = collect($this->data['Num_d']);
//        $data = $collect->where('number', $num_d)->toArray();
            if ($user) {
                $user->password = $post['password'];
                $user->verify = null;
                if ($user->save()) {
                    return view('site.cabinet.settings', [
                        'success' => true,
                        'user' => $this->user,
//                    'data' => $data[1],
//                    'id' => $num_d
                    ]);
                }
            }

            return view('site.cabinet.settings', [
                'success' => false
            ]);
        }

        public function CheckPV(Request $request, $num_d)
        {
            $before_date = $request->input('before_date');

            if ($request->input('before_date')) {
                $date_zp = Carbon::parse($before_date)->format('YmdHis');
                $before_date = $request->input('before_date');
            } else {
                $date_zp = Carbon::now()->format('YmdHis');
                $before_date = null;
            }
            $pv = $this->api->CheckPV([
                "iin" => $this->user->iin,
                "Num_d" => $num_d,
                "date_zp" => $date_zp
            ])->_toArray();

            $data = $this->data;
            if (isset($data)) {
                $dogovor = $data['Num_d'];

                if (!isset($dogovor[0]['number'])) {
                    $dogovor = [];
                    $dogovor[] = $data['Num_d'];
                }
            }

            $collect = collect($dogovor);
            $data = $collect->where('number', $num_d)->toArray();
            $data = array_values($data);

            return view('site.cabinet.check_pv', [
                'user' => $this->user,
                'before_date' => $before_date,
                'id' => $num_d,
                'data' => $data[0],
                'pv' => $pv,
                'request' => $request
            ]);
        }

        public function CheckCHDP(Request $request, $num_d)
        {
            $before_date = $request->input('before_date');
            $summa_chdp = $request->input('summa_chdp');

            if ($request->input('summa_chdp')) {
                $date_zp = Carbon::parse($before_date)->format('YmdHis');
                if (!is_numeric($summa_chdp)) {
                    $error_chdp = 'Вы ввели неверный формат суммы';
                    $chdp = null;
                } else {
                    $error_chdp = null;

                    $chdp = $this->api->CheckCHDP([
                        "iin" => $this->user->iin,
                        "Num_d" => $num_d,
                        "date_zp" => $date_zp,
                        "SummaCHDP" => $summa_chdp
                    ])->_toArray();
                }
            } else {
                $date_zp = Carbon::now()->format('YmdHis');
                $summa_chdp = null;
                $before_date = null;
                $error_chdp = 'Вы не ввели сумму погашения';
                $chdp = null;
            }

            $data = $this->data;
            if (isset($data)) {
                $dogovor = $data['Num_d'];

                if (!isset($dogovor[0]['number'])) {
                    $dogovor = [];
                    $dogovor[] = $data['Num_d'];
                }
            }

            $collect = collect($dogovor);
            $data = $collect->where('number', $num_d)->toArray();
            $data = array_values($data);

            return view('site.cabinet.check_chdp', [
                'user' => $this->user,
                'before_date' => $before_date,
                'summa_chdp' => $summa_chdp,
                'error_chdp' => $error_chdp,
                'id' => $num_d,
                'data' => $data[0],
                'chdp' => $chdp,
                'request' => $request
            ]);
        }

        public function feedback($num_d)
        {
            $vid = $this->api->CheckVid()->_toArray();
            $data = $this->data;
            if (isset($data)) {
                $dogovor = $data['Num_d'];

                if (!isset($dogovor[0]['number'])) {
                    $dogovor = [];
                    $dogovor[] = $data['Num_d'];
                }
            }
            $collect = collect($dogovor);
            $data = $collect->where('number', $num_d)->toArray();
            $data = array_values($data);

            return view('site.cabinet.feedback', [
                'user' => $this->user,
                'id' => $num_d,
                'data' => $data[0],
                'vid' => $vid,
                'dontShowNotification' => true
            ]);
        }

        public function feedback_template($num_d, Request $request)
        {
//        $vid = $this->api->CheckVid()->_toArray();
            $vid = [
                "code" => 200,
                "data" => [
                    "result" => "0",
                    "comment" => "ОК",
                    "vid_docs" => [
                        "vid" => [
                            0 => [
                                "name" => "Частично досрочное погашение\n",
                                "kod" => "1",
                            ],
                            1 => [
                                "name" => "Полный досрочный выкуп",
                                "kod" => "2",
                            ],
                            2 => [
                                "name" => "Полный досрочный выкуп со списанием пени в размере 90%",
                                "kod" => "3",
                            ],
                            3 => [
                                "name" => "Частично досрочное погашение за счет ЕПВ",
                                "kod" => "4",
                            ],
                            4 => [
                                "name" => "Полный досрочный выкуп за счет ЕПВ",
                                "kod" => "5",
                            ],
                            5 => [
                                "name" => "Справка о всех поступивших платежах",
                                "kod" => "6",
                            ],
                            6 => [
                                "name" => "Согласие на передачу в субаренду",
                                "kod" => "7",
                            ],
                            7 => [
                                "name" => "Согласие на постоянную прописку",
                                "kod" => "8",
                            ],
                            8 => [
                                "name" => "Расторжение договора",
                                "kod" => "9",
                            ],
                            9 => [
                                "name" => "Свободное обращение",
                                "kod" => "10",
                            ]
                        ]
                    ]
                ]
            ];
            $data = $this->data;
            if (isset($data)) {
                $dogovor = $data['Num_d'];

                if (!isset($dogovor[0]['number'])) {
                    $dogovor = [];
                    $dogovor[] = $data['Num_d'];
                }
            }
            $collect = collect($dogovor);
            $data = $collect->where('number', $num_d)->toArray();
            $data = array_values($data);
            $data[0]['date_d'] = Carbon::createFromDate($data[0]['date_d'])->format('d/m/Y');

            return view('site.cabinet.feedback', [
                'user' => $this->user,
                'id' => $num_d,
                'data' => $data[0],
                'vid' => $vid,
                'chosen_code_id' => $request['chosen_code_id'],
                'editing' => (is_null(
                        $request['editing']
                    ) || $request['editing'] == 1) ? Appeal::STATUS['VIEW'] : Appeal::STATUS['EDIT'],
                'values' => $request->all(),
                'today_date' => Carbon::now()->format('d/m/Y'),
                'dontShowNotification' => true,
                'appealsHistory' => AppealHistory::where('user_id', $this->user->id)->get(),
            ]);
        }

        /**
         * @param Request $request
         * @return BinaryFileResponse
         */
        public function downloadPdfAppeal(Request $request): BinaryFileResponse
        {
            $signerInfo = '';
            if ($request['signed']) {
//                $signerInfo = $this->kalkanCryptService->verifySignature($request['signature_cms'], $request['document_base64']);
            }
            return $this->appealService->downloadPdf($request, $this->data, $signerInfo);
        }

        /**
         * @param SendAppealTemplateRequest $request
         * @return void
         */
        public
        function sendAppealTemplate(
            Request $request
        ) {
            $this->createCmsFile($request['cms_signature']);
            $signerInfo = '';
            if ($request['signed']) {
//                $signerInfo = $this->kalkanCryptService->verifySignature($request['signature_cms'], $request['document_base64']);
            }
            $this->appealService->sendAppealAndAddToHistory($request, $this->data, $signerInfo);
        }

        /**
         * @param  $cms
         * @return void
         */
        private function createCmsFile($cms)
        {
            $decodedCms = base64_decode($cms);
            $rawBytes = "";
            foreach (str_split($decodedCms) as $byte) {
                $rawBytes .= ' ' . sprintf("%08b", ord($byte));
            }
            $path = Storage::disk('temp_pdf')->path("file.pdf.cms");
            $file_w = fopen($path, 'wb+');
            fwrite($file_w, bindec($rawBytes));
            fclose($file_w);
        }

        /**
         * @param $appeal_history_id
         * @param $reply
         * @return void
         */
        public
        function replyToAppeal(
            $appeal_history_id,
            $reply
        ) {
            $appeal_history = AppealHistory::find($appeal_history_id);
            $appeal_history->reply = $reply;
            $appeal_history->save();
        }

        /**
         * @param $appeal_history_id
         * @param $status
         * @return void
         */
        public
        function changeStatusOfAppeal(
            $appeal_history_id,
            $status
        ) {
            $appeal_history = AppealHistory::find($appeal_history_id);
            $appeal_history->status = $status;
            $appeal_history->save();
        }

        /**
         * @param $file
         * @return void
         */
        private
        function feedbackSendEmail(
            $file
        ) {
            Mail::send('appeals_pdf_templates.partial_early_repayment_pdf', [], function ($message) use ($file) {
                $message->from('no-reply@astana.kz', 'Запись на прием - astana.gov.kz');
                $message->subject('Запись на прием - Акимат Астаны');
                $message->to('kozykorpesh.tolep@gmail.com');
                $message->attach($file);
            });
        }


        /**
         * @param Request $request
         * @param int $num_d
         * @return RedirectResponse
         */
        public
        function feedbackSend(
            Request $request,
            int $num_d
        ): RedirectResponse {
            $validator = Validator::make($request->input(), [
                'type_doc' => 'required',
                'text_doc' => 'required'
            ], [
                'type_doc.required' => 'Тема обращения не выбрана',
                'text_doc.required' => 'Текст обращения не заполнен'
            ]);

            if (!$validator->fails()) {
                $send = $this->api->Zayavka([
                    "iin" => $this->user->iin,
                    "Num_d" => $num_d,
                    "txn_date" => Carbon::now()->format('YmdHis'),
                    "type_doc" => $request->input('type_doc'),
                    "text_doc" => $request->input('text_doc')
                ])->_toArray();

                if ($send['data']['result'] == 0) {
                    return redirect()->back()->with('success', $send['data']['nomer_doc']);
                } else {
                    return redirect()->back()->with('errorr', 'Ошибка связи с сервером попробуйте позднее');
                }
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        /**
         * @param Request $request
         * @return RedirectResponse
         */
        public
        function saveRelevantProfileData(
            Request $request
        ): RedirectResponse {
            $request->validate([
                'email' => 'required|email|unique:users,email,' . $this->user->id,
                'mobile' => 'required|unique:users,mobile,' . $this->user->id,
            ]);
            User::find($this->user->id)->update([
                'mobile' => $request['mobile'],
                'email' => $request['email'],
                'address' => $request['address'],
                'work_phone' => $request['work_phone'],
                'homephone' => $request['home_phone'],
                'last_profile_check_at' => Carbon::now(),
            ]);
            return redirect()->back();
        }

        /**
         * @return BinaryFileResponse
         */
        public
        function exportExcelOfUsers(): BinaryFileResponse
        {
            return Excel::download(new UsersExport(), 'invoices.xlsx');
        }

        /**
         * @param Request $request
         * @return JsonResponse
         */
        public
        function signDocument(
            Request $request
        ): JsonResponse {
            return $this->kalkanCryptService->signDocument($request);
        }

        /**
         * @param Request $request
         * @return void
         */
        public
        function saveConsentToDataCollectionAsCms(
            Request $request
        ) {
            $this->kalkanCryptService->createCmsFile($request['signature_cms']);
        }

    }
