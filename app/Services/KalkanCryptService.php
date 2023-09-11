<?php

    namespace App\Services;

    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;

    /**
     *
     */
    class KalkanCryptService
    {
        /**
         * @var int
         */
        const KC_PROXY_AUTH = 0x00004000;
        /**
         *
         */
        const KC_OUT_BASE64 = 0x800;
        /**
         *
         */
        const KC_NOCHECKCERTTIME = 0x10000;
        /**
         *
         */
        const KC_CERTPROP_SUBJECT_COMMONNAME = 0x80a;
        /**
         *
         */
        const KC_CERTPROP_SUBJECT_GIVENNAME = 0x80b;
        /**
         *
         */
        const KC_CERTPROP_SUBJECT_SURNAME = 0x80c;
        /**
         *
         */
        const KC_CERTPROP_SUBJECT_SERIALNUMBER = 0x80d;
        /**
         *
         */
        const KC_CERTPROP_NOTAFTER = 0x00000814;
        /**
         *
         */
        const KC_CERTPROP_NOTBEFORE = 0x00000813;
        /**
         *
         */
        const KC_IN_BASE64 = 0x10;
        /**
         *
         */
        const KC_SIGN_CMS = 0x2;
        /**
         *
         */
        const KC_OUT_PEM = 0x200;

        /**
         * @var array|string|string[]
         */
        protected $FIOCertificateOwner;

        /**
         * @var array|string|string[]
         */
        private $IINCertificateOwner;

        /**
         * @var array|string|string[]
         */
        private $ValidFromCertificateOwner;
        /**
         * @var array|string|string[]
         */
        private $ValidToCertificateOwner;

        /**
         * @param $outSign
         * @param $inData
         * @return JsonResponse|string
         */
        public
        function verifySignature(
            $outSign,
            $inData
        ) {
            $alias = "";
            $flags_sign = self::KC_SIGN_CMS + self::KC_IN_BASE64 + self::KC_OUT_BASE64 + self::KC_NOCHECKCERTTIME;
            $outData = "";
            $outVerifyInfo = "";
            $outCert = "";
            $err = KalkanCrypt_VerifyData(
                $alias,
                $flags_sign,
                $inData,
                0,
                $outSign,
                $outData,
                $outVerifyInfo,
                $outCert
            );
            if ($err > 0) {
                return response()->json(['error' => KalkanCrypt_GetLastErrorString()], 403);
            } else {
                $this->getCertificateFromCms($outSign);
                return $this->getCertificateOwnerInfo();
            }
        }

        /**
         * @return string
         */
        private function getCertificateOwnerInfo(): string
        {
//        return "Куралбаева Ажар Асанкызы, 740228909312";
            return "{$this->FIOCertificateOwner}, {$this->IINCertificateOwner}";
        }

        /**
         * @param $outSign
         * @return JsonResponse|void
         */
        private
        function getCertificateFromCms(
            $outSign
        ) {
            $inSignID = 1;
            $flags_sign = self::KC_IN_BASE64 + self::KC_SIGN_CMS + self::KC_OUT_PEM;
            $outCert = "";
            $err = KalkanCrypt_getCertFromCMS($outSign, $inSignID, $flags_sign, $outCert);
            if ($err > 0) {
                return response()->json(['error' => KalkanCrypt_GetLastErrorString()], 403);
            } else {
                print_r($outCert);
                $this->getInfoFromCertificate($outCert);
            }
        }

        /**
         * @param string $outCert
         * @return JsonResponse|void
         */
        private function getInfoFromCertificate(string $outCert): JsonResponse
        {
            $outData = "";
            $err = KalkanCrypt_X509CertificateGetInfo(self::KC_CERTPROP_SUBJECT_COMMONNAME, $outCert, $outData);
            if ($err > 0) {
                if ($err != 149946424) {
                    return response()->json(['error' => KalkanCrypt_GetLastErrorString()], 403);
                }
            } else {
                $this->FIOCertificateOwner = str_replace("CN=", "", $outData);
            }
            $err = KalkanCrypt_X509CertificateGetInfo(self::KC_CERTPROP_SUBJECT_SERIALNUMBER, $outCert, $outData);
            if ($err > 0) {
                if ($err != 149946424) {
                    return response()->json(['error' => KalkanCrypt_GetLastErrorString()], 403);
                }
            } else {
                $this->IINCertificateOwner = str_replace("serialNumber=IIN", "", $outData);
            }
            $err = KalkanCrypt_X509CertificateGetInfo(self::KC_CERTPROP_NOTBEFORE, $outCert, $outData);
            if ($err > 0) {
                if ($err != 149946424) {
                    return response()->json(['error' => KalkanCrypt_GetLastErrorString()], 403);
                }
            } else {
                $search = [" ALMT", "notBefore="];
                $this->ValidFromCertificateOwner = str_replace($search, "", $outData);
            }
            $err = KalkanCrypt_X509CertificateGetInfo(self::KC_CERTPROP_NOTAFTER, $outCert, $outData);
            if ($err > 0) {
                if ($err != 149946424) {
                    return response()->json(['error' => KalkanCrypt_GetLastErrorString()], 403);
                }
            } else {
                $search = [" ALMT", "notAfter="];
                $this->ValidToCertificateOwner = str_replace($search, "", $outData);
            }
        }

        /**
         * @param Request $request
         * @return JsonResponse
         */
        public function signDocument(Request $request): JsonResponse
        {
            KalkanCrypt_Init();
            $flag_proxy = self::KC_PROXY_AUTH;
            $inProxyAddr = "192.168.39.241";
            $inProxyPort = "9090";
            $inUser = "";
            $inPass = "";
            $err = KalkanCrypt_SetProxy($flag_proxy, $inProxyAddr, $inProxyPort, $inUser, $inPass);
//$tsaurl = "http://test.pki.gov.kz:80//tsp/";
            $tsaurl = "http://test.pki.gov.kz/tsp/";
//$tsaurl = "http://tsp.pki.gov.kz:80";
            KalkanCrypt_TSASetUrl($tsaurl);
            if ($err > 0) {
                return response()->json(['error' => KalkanCrypt_GetLastErrorString()], 403);
            } else {
                //проверить подпись
                $this->verifySignature($request['signature_cms'], $request['document_base64']);
            }
            return response()->json(
                [
                    "fio" => $this->FIOCertificateOwner,
                    "iin" => $this->IINCertificateOwner,
                    'certificate_valid_from' => $this->ValidFromCertificateOwner,
                    'certificate_valid_to' => $this->ValidToCertificateOwner
                ]
            );
        }

        /**
         * @return void
         */
        private
        function checkCertificate()
        {
//        KalkanCrypt_X509LoadCertificateFromFile(self::KC_CERT_CA).
        }
    }
