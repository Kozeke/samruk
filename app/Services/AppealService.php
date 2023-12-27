<?php

    namespace App\Services;

    use App\Http\Requests\SendAppealTemplateRequest;
    use App\Models\AppealHistory;
    use App\Models\User;
    use Carbon\Carbon;
    use Dompdf\Dompdf;
    use Dompdf\Options;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;
    use Milon\Barcode\DNS1D;
    use Milon\Barcode\DNS2D;
    use DB;
    use Symfony\Component\HttpFoundation\BinaryFileResponse;

    /**
     *
     */
    class AppealService
    {
        /**
         *
         */
        const FILE_EXTENSION = '.pdf';

        /**
         * @var string
         */
        private $feedbackText;

        /**
         * @var string
         */
        private $signerInfo;

        /**
         * @param Request $request
         * @param array $data
         * @param string $signerInfo
         * @return BinaryFileResponse
         */
        public function downloadPdf(Request $request, array $data, string $signerInfo): BinaryFileResponse
        {
            $this->signerInfo = $signerInfo;
            $fileName = $this->createPdf($request, $data);
            $appealTemplateTitle = DB::table('appeal_templates')->where('id', $request['selected_code_id'])->first(
            )->title;
            $fullPathToTempPDF = Storage::disk('temp_pdf')->path($fileName);
            return response()->download($fullPathToTempPDF, $appealTemplateTitle)->deleteFileAfterSend(true);
        }

        /**
         * @param Request $request
         * @param array $data
         * @return string
         */
        private function createPdf(Request $request, array $data): string
        {
            if ($request['date_to_finish']) {
                $request['date_to_finish'] = Carbon::createFromDate(
                    $request['date_to_finish']
                )->format('d/m/Y');
            }
            if ($request['date_to']) {
                $request['date_to'] = Carbon::createFromDate(
                    $request['date_to']
                )->format('d/m/Y');
            }
            $data = $data['Num_d'];
            $data['date_d'] = Carbon::createFromDate($data['date_d'])->format('d/m/Y');
            unset($request['_token']);

            $options = new Options();
            $options->set('defaultFont', 'times_new_roman_cyr');
            $pdf = new Dompdf($options);
            $html = $this->getHeaderHtml($data);
            $html .= $this->getContentHtmlForCodeId($data, $request, $request['selected_code_id']);
            $html .= $this->getFooterHtml($request);

            $pdf->load_html($html, 'UTF-8');
            $pdf->render();

            $fileName = $this->getNameCreatedTempFile() . self::FILE_EXTENSION;
            Storage::disk('temp_pdf')->put($fileName, $pdf->output());

            return $fileName;
        }

        /**
         * @return string
         */
        private
        function getNameCreatedTempFile(): string
        {
            return uniqid(rand(), true);
        }

        /**
         * @param $data
         * @param $values
         * @param $selectedCodeId
         * @return string
         */
        private function getContentHtmlForCodeId($data, $values, $selectedCodeId): string
        {
            switch ($selectedCodeId) {
                case 1:
                    return $this->getContentHtmlForPartialEarlyRepayment($data, $values);
                case 2:
                    return $this->getContentHtmlForFullEarlyRedemption($data, $values);
                case 3:
                    return $this->getContentHtmlForFullEarlyRedemptionWithPenalty($data, $values);
                case 4:
                    return $this->getContentHtmlForPartialEarlyRedemptionAtTheExpense($data, $values);
                case 5:
                    return $this->getContentHtmlForFullEarlyRedemptionAtTheExpense($data, $values);
                case 6:
                    return $this->getContentHtmlForPartialInformationAboutAllReceivedPayments($data);
                case 7:
                    return $this->getContentHtmlForConsentToSublease($data, $values);
                case 8:
                    return $this->getContentHtmlForConsentForPermanentResidence($data, $values);
                case 9:
                    return $this->getContentHtmlForConsentForTerminationOfAgreement($data, $values);
                case 10:
                    return $this->getContentHTMLWhenNoTemplate($values);
                default:
                    return '';
            }
        }

        /**
         * @param array $data
         * @return string
         */
        private function getHeaderHtml(array $data): string
        {
            $user = Auth::user();
            return <<<HTML
        <div style="font-size: 14px;margin-top: -15px">
            <p style="text-align: right;">Председателю Правления</p>
            <p style="text-align: right;">АО &laquo;Samruk-Kazyna Construction&raquo;</p>
            <p style="text-align: right;">г-ну Айманбетову М.З.</p>
            <p style="text-align: right;">От Арендатора ЖК &nbsp;<u>{$data['AdressJK']}</u></p>
            <p style="text-align: right;"><u>{$data['Number_room']}</u></p>
            <p style="text-align: right;">ФИО&nbsp;<u>{$user->name}</u></p>
            <p style="text-align: right;">ИИН&nbsp;<u>{$user->iin}</u></p>
            <p style="text-align: right;">Сот.&nbsp;<u>{$user->mobile}</u></p>
            <p style="text-align: right;">E-mail &nbsp;<u>{$user->email}</u></p>
            <p style="margin-bottom: 50px"><br></p>
        </div>

HTML;
        }

        /**
         * @param $data
         * @param $values
         * @return string
         */
        private function getContentHtmlForPartialEarlyRepayment($data, $values): string
        {
            $htmlTitle = <<<HTML
        <div style="font-size: 14px; margin-bottom:30px">
            <p style=";text-align: center;font-size: 16px"><strong>Частично досрочное погашение</strong></p>
            <p>&nbsp;</p>
            <p style="text-align: center;font-size: 16px"><strong>ЗАЯВЛЕНИЕ</strong></p>
            <p>&nbsp;</p>
            <p style="text-indent: 45px">
HTML;
            $htmlText = "Настоящим прошу Вас разрешить внести на частично досрочное погашение сумму в
                размере {$values['price']} тенге по Договору аренды с выкупом жилого помещения от {$data['date_d']} года &nbsp;№{$data['number']},
                на {$values['date_to_finish']} года.";
            $this->feedbackText = $htmlText;
            $htmlEnd = <<<HTML
</p>
            <p><br></p>
            <p><br></p>
            <p><br></p>
        </div>
HTML;
            return $htmlTitle . $htmlText . $htmlEnd;
        }

        /**
         * @param $data
         * @param $values
         * @return string
         */
        private function getContentHtmlForFullEarlyRedemptionWithPenalty($data, $values): string
        {
            $htmlTitle = <<<HTML
        <div style="margin-bottom: 80px; font-size: 14px">
         <p style="text-align: center; font-size: 16px"><strong>Полный досрочный выкуп со
                        списанием пени в размере 90%</strong></p>
            <p>&nbsp;</p>
            <p style="text-align: center;"><strong>ЗАЯВЛЕНИЕ</strong></p>
            <p>&nbsp;</p>
            <p style="text-indent: 45px">
HTML;
            $htmlText = "Прошу Вас разрешить произвести полный досрочный выкуп с возможностью списания 90% начисленной пени
                арендуемого мною помещения, расположенного по адресу: {$data['JK']} согласно условий Договора
                аренды с выкупом от {$data['date_d']} года № {$data['number']}, до периода {$values['date_to_finish']}.
            В случае неосуществления мной оплаты остатка стоимости помещения до
                    периода {$values['date_to']} года, прошу аннулировать данное заявление (оставить без рассмотрения).";
            $this->feedbackText = $htmlText;
            $htmlEnd = <<<HTML
            </p>
            </div>
HTML;
            return $htmlTitle . $htmlText . $htmlEnd;
        }

        /**
         * @param $data
         * @param $values
         * @return string
         */
        private function getContentHtmlForFullEarlyRedemption($data, $values): string
        {
            $htmlTitle = <<<HTML
        <div style="font-size: 14px; margin-bottom: 100px">
        <p style="font-size: 16px; text-align: center"><strong>Полный досрочный выкуп</strong></p>
        <p>&nbsp;</p>
        <p style="font-size: 16px;text-align: center;"><strong>ЗАЯВЛЕНИЕ</strong></p>
        <p>&nbsp;</p>
        <p style="text-indent: 45px">
HTML;
            $htmlText = "Прошу Вас разрешить произвести полный досрочный выкуп арендуемого мною жилого помещения, расположенного по
        адресу: {$data['JK']} согласно условий Договора аренды с выкупом жилого помещения от {$data['date_d']}
        года № {$data['number']} (далее &ndash; Договор), по состоянию на {$values['date_to_finish']} года.";
            $this->feedbackText = $htmlText;
            $htmlEnd = <<<HTML
        </p>
        </div>
HTML;
            return $htmlTitle . $htmlText . $htmlEnd;
        }

        /**
         * @param $data
         * @param $values
         * @return string
         */
        private function getContentHtmlForFullEarlyRedemptionAtTheExpense($data, $values): string
        {
            $htmlTitle = <<<HTML
           <div style="font-size: 14px; margin-bottom: 80px">
                <p style="text-align: center;font-size: 16px"><strong>Полный досрочный выкуп за счет ЕПВ</strong></p>
                <p>&nbsp;</p>
                <p style="text-align: center;font-size: 16px"><strong>ЗАЯВЛЕНИЕ</strong></p>
                <p>&nbsp;</p>
                <span style="text-indent: 45px">
HTML;
            $htmlText = "Прошу Вас предоставить справку о задолженности в целях полного погашения остатка стоимости арендуемого мною жилого помещения,
                    расположенного по адресу:&nbsp;{$data['JK']}&nbsp;
                    согласно условий Договора аренды с выкупом жилого помещения от {$data['date_d']} года № {$data['number']} (далее &ndash; Договор), по состоянию на
                    {$values['date_to_finish']} года , за счет денежных средств ЕПВ (доступная сумма {$values['price']} тенге).";
            $this->feedbackText = $htmlText;
            $htmlEnd = <<<HTML
            </span>
            </div>
HTML;
            return $htmlTitle . $htmlText . $htmlEnd;
        }

        /**
         * @param $data
         * @param $values
         * @return string
         */
        private function getContentHtmlForPartialEarlyRedemptionAtTheExpense($data, $values): string
        {
            $htmlTitle = <<<HTML
          <div style="font-size: 14px; margin-bottom: 60px">
            <p style="text-align: center;font-size: 16px"><strong>Частично досрочное погашение за счет ЕПВ&nbsp;</strong></p>
            <p>&nbsp;</p>
            <p style="text-align: center;font-size: 16px"><strong>ЗАЯВЛЕНИЕ</strong></p>
            <p>&nbsp;</p>
            <p style="text-indent: 45px">
HTML;
            $htmlText = "Прошу Вас предоставить справку о задолженности в целях частично досрочного погашения остатка стоимости
                арендуемого мною жилого помещения, расположенного по адресу: {$data['JK']}
                согласно условий Договора аренды с выкупом жилого помещения от {$values['date_to_finish']} года № {$data['number']}
                авто (далее &ndash; Договор), по состоянию на {$data['date_d']} года, за счет денежных средств ЕПВ (доступная сумма
                {$values['price']} тенге).";
            $htmlEnd = <<<HTML
            </p>
            <p><br></p>
            </div>
HTML;
            return $htmlTitle . $htmlText . $htmlEnd;
        }

        /**
         * @param $data
         * @return string
         */
        private function getContentHtmlForPartialInformationAboutAllReceivedPayments($data): string
        {
            $htmlTitle = <<<HTML
          <div style="font-size: 14px; margin-bottom: 150px">
           <p style="text-align: center; font-size: 16px"><strong>Справка о всех поступивших платежах</strong></p>
            <p>&nbsp;</p>
            <p style="text-indent: 45px">
HTML;
            $htmlText = "Настоящим прошу Вас предоставить справку о всех поступивших платежах по Договору
            аренды с выкупом от {$data['date_d']} г. &nbsp;№ {$data['number']}.&nbsp;";
            $htmlEnd = <<<HTML
            </p>
            <p><br></p>
            </div>
HTML;
            return $htmlTitle . $htmlText . $htmlEnd;
        }

        /**
         * @param $data
         * @param $values
         * @return string
         */
        private function getContentHtmlForConsentToSublease($data, $values): string
        {
            $htmlTitle = <<<HTML
          <div style="font-size: 14px; margin-bottom: 10px">
           <p><br></p>
            <p style="font-size: 16px; text-align: center"><strong>Согласие на передачу в субаренду</strong>
            </p>
            <p><span>&nbsp;</span>
            </p>
            <p style="font-size: 16px; text-align: center"><strong> ЗАЯВЛЕНИЕ</strong>
            </p>
            <p>&nbsp;</p>
            <p style="text-indent: 45px">
HTML;
            $htmlText = "Прошу Вас разрешить сдать в субаренду арендуемое мною жилое помещение, расположенное по адресу
                {$data['JK']}, согласно условий Договора аренды с выкупом жилого помещения от {$data['date_d']}
                №{$data['number']} в связи с {$values['reason']}
         </p>
            </p>
            <p><strong>Прилагается</strong></p>
            <p>1) {$values['attachment_one']}</p>
            <p>2) {$values['attachment_two']}</p>";
            $this->feedbackText = $htmlText;
            $htmlEnd = <<<HTML
            </p>
            </div>
HTML;
            return $htmlTitle . $htmlText . $htmlEnd;
        }

        /**
         * @param $data
         * @param $values
         * @return string
         */
        private function getContentHtmlForConsentForPermanentResidence($data, $values): string
        {
            $user = Auth::user();
            $htmlTitle = <<<HTML
          <div style="font-size: 14px;">
            <p style="font-size: 16px; text-align: center"><strong
            >Согласие на постоянную прописку</strong>
            </p>
            <p>&nbsp;</p>
            <p style="font-size: 16px; text-align: center"><strong
                >Заявление</strong>
            </p>
            <p>&nbsp;</p>
            <p>
                <span>
HTML;
            $htmlText = "Прошу Вас дать согласие на регистрацию меня в Департаменте &quot;Центр обслуживания населения -
                филиала НАО&quot; Государственная корпорация &quot;Правительство для граждан&quot; по адресу: {$data['JK']}
        </span>
            </p>
            <p><span>{$user['name']}</span>
            </p>
            <p><strong>и членов моей семьи</strong></p>
            <p>1) {$values['attachment_one']}</p>
            <p>2) {$values['attachment_two']}</p>
            <p><span>на постоянное место жительство по адресу: </span><span>{$data['JK']}&nbsp;</span>
         </div>";
            $this->feedbackText = $htmlText;

            return $htmlTitle . $htmlText;
        }

        /**
         * @param $data
         * @param $values
         * @return string
         */
        private function getContentHtmlForConsentForTerminationOfAgreement($data, $values): string
        {
            $htmlTitle = <<<HTML
        <div style="font-size: 14px; margin-bottom: 100px">
         <p style="font-size: 18px; text-align: center"><strong>Расторжение договора</strong></p>
            <p>&nbsp;</p>
            <p style="font-size: 18px; text-align: center"><strong>ЗАЯВЛЕНИЕ</strong></p>
            <p>&nbsp;</p>
            <span style="text-indent: 45px">
HTML;
            $htmlText = "В связи с {$values['reason']} прошу Вас расторгнуть Договор аренды с выкупом жилого помещения от {$data['date_d']} года
                №{$data['number']} авто (далее &ndash; Договор) согласно утвержденной процедуре.";
            $htmlEnd = "</span></div>";
            return $htmlTitle . $htmlText . $htmlEnd;
        }

        /**
         * @param $values
         * @return string
         */
        private function getContentHTMLWhenNoTemplate($values): string
        {
            $htmlTitle = <<<HTML
        <div style="font-size: 14px; margin-bottom: 100px">
         <p style="font-size: 18px; text-align: center"><strong>{$values['appeal_title']}</strong></p>
            <p>&nbsp;</p>
            <p style="font-size: 18px; text-align: center"><strong>ЗАЯВЛЕНИЕ</strong></p>
            <p>&nbsp;</p>
            <span style="text-indent: 45px">
HTML;

            $htmlEnd = "</span></div>";
            return $htmlTitle . $values['appeal_text'] . $htmlEnd;
        }


        /**
         * @param Request $request
         * @param array $data
         * @return string
         */
        private function getFooterHtml(Request $request): string
        {
            $today_date = Carbon::now()->format('d/m/Y');
            $html = "<p style='text-align: right;'>{$today_date}</p>";
            if ($request['signed']) {
                $html .= "<div style='right:0px;position: absolute;'>";
                if ($this->signerInfo) {
//                    $html .= DNS2D::getBarcodeHTML($this->signerInfo, 'QRCODE', 5, 5) . "</div>";
                    $html .= "<img src='data:image/png;base64," . DNS1D::getBarcodePNG(
                            'asdasd',
                            'S25'
                        ) . "alt='barcode' />";
                    $html .= "<div style='bottom: 0px;position: absolute'> <p style='font-size: 10px'>
            Данный документ согласно пункту 1 статьи 7 ЗРК от 7 января 2003 года N370-II \"Об электронном документе и электронной цифровой подписи\" равнозначен документу на бумажном носителе.</p>";
                    $html .= "</div></div>";
                }
//            Осы құжат \"Электрондық құжат және электрондық цифрлық қолтаңба туралы\" Қазақстан Республикасының 2003 жылғы 7
//            қаңтардағы N 370-II Заңы 7 бабының 1 тармағына сәйкес қағаз тасығыштағы құжатпен бірдей.
            } else {
                $html .= "<p style='text-align: right;'>Подпись:</p>
                <p style='text-align: right;'>Код подпись от ЭЦП</p></div>";
            }
            return $html;
        }

        /**
         * @param Request $request
         * @param array $data
         * @param string $signerInfo
         * @return void
         */
        public
        function sendAppealAndAddToHistory(
            Request $request,
            array $data,
            string $signerInfo
        ) {
            $this->signerInfo = $signerInfo;
            $template_title = DB::table('appeal_templates')->where('code', $request['selected_code_id'])->first(
            )->title;
            $fileName = $this->createPdf($request, $data);
            $fullPathToTempPDF = config('filesystems.disks.temp_pdf.url') . '/' . $fileName;
            $this->addToAppealHistory(
                Auth::user()->id,
                $fullPathToTempPDF,
                $template_title,
                $request['signature_cms'],
                $request['document_base64']
            );
            $this->createCmsFile($request['signature_cms']);
        }

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
         * @param $id
         * @param $fullPathToTempPDF
         * @param $template_title
         * @param $cmsPdf
         * @param $basePdf
         * @return void
         */
        private
        function addToAppealHistory(
            $id,
            $fullPathToTempPDF,
            $template_title,
            $cmsPdf,
            $basePdf
        ) {
            AppealHistory::create([
                'user_id' => $id,
                'link' => $fullPathToTempPDF,
                'status' => AppealHistory::STATUS_SENT,
                'title' => $template_title,
                'cms_pdf' => $cmsPdf,
                'base_pdf' => $basePdf,
            ]);
        }


    }
