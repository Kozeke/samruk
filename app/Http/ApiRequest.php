<?php

namespace App\Http;

use SoapClient;

class ApiRequest
{
    /**
     * @var client for soap fnsk
     */
    protected $client;

    /**
     * @var Url to fnsk soap server
     */
//    protected $url = 'https://suap.fnsk.kz/SUAP/ws/BankExchange.1cws?wsdl';
    protected $url = 'http://example.com/webservices?wsdl';
    /**
     * @var result
     */
    protected $result;

    /**
     * ApiRequest constructor.
     * @throws \SoapFault
     */
    public function __construct()
    {
        ini_set('default_socket_timeout', 10000);
        $this->client = new SoapClient($this->url, [
            "soap_version" => SOAP_1_1,
            "stream_context" => stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ])
        ]);
        $this->getSoap();
    }

    private function getSoap()
    {
        $opts = array(
            'http' => array(
                'user_agent' => 'PHPSoapClient'
            )
        );
        $context = stream_context_create($opts);

        //$wsdlUrl = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';
        $soapClientOptions = array(
            'stream_context' => $context,
            'cache_wsdl' => WSDL_CACHE_NONE
        );

        $client = new SoapClient($this->url, $soapClientOptions);
        /**$checkVatParameters = array(
         * 'countryCode' => 'DK',
         * 'vatNumber' => '47458714'
         * );
         *
         * $result = $client->checkVat($checkVatParameters);
         * print_r($result);*/
    }

    public function CheckByInfoByClient($data = [])
    {

        if (is_array($data)) {
            if (isset($data['iin'], $data['num_phone'], $data['date_zp'])) {
//                $this->result = $this->client->CheckByInfoByClient($data);
            }
        }
        return $this;
    }

    public function CheckByPhone($data = [])
    {
        if (is_array($data)) {
            if (isset($data['iin'], $data['num_phone'])) {
//                $this->result = $this->client->CheckByPhone($data);
            }
        }

        return $this;
    }

    public function CheckInfo($data = [])
    {
        if (is_array($data)) {
            if (isset($data['iin'], $data['num_phone'], $data['num_d'], $data['date_zp'])) {
//                $this->result = $this->client->CheckInfo($data);
            }
        }

        return $this;
    }

    public function CheckMainInfo($data = [])
    {
        if (is_array($data)) {
            if (isset($data['iin'], $data['num_phone'], $data['date_zp'], $data['num_d'])) {
                $this->result = $this->client->CheckMainInfo($data);
            }
        }

        return $this;
    }

    public function CheckAkt($data = [])
    {
        if (is_array($data)) {
            if (isset($data['iin'], $data['Num_d'], $data['date_akt'])) {
                $this->result = $this->client->CheckAkt($data);
            }
        }

        return $this;
    }

        public function Checkgrafic($data = [])
    {
        if (is_array($data)) {
            if (isset($data['iin'], $data['Num_d'], $data['date_zp'])) {
                $this->result = $this->client->Checkgrafic($data);
            }
        }
        return $this;
    }

        public function CheckCHDP($data = [])
    {
        if (is_array($data)) {
            if (isset($data['iin'], $data['Num_d'], $data['date_zp'], $data['SummaCHDP'])) {
                $this->result = $this->client->CheckCHDP($data);
            }
        }
        return $this;
    }

    public function CheckPV($data = [])
    {
        if (is_array($data)) {
            if (isset($data['iin'], $data['Num_d'], $data['date_zp'])) {
                $this->result = $this->client->CheckPV($data);
            }
        }
        return $this;
    }

    public function CheckVid($data = [])
    {
        if (is_array($data)) {
            $this->result = $this->client->CheckVid($data);
        }
        return $this;
    }

    public function Zayavka($data = [])
    {
        if (is_array($data)) {
            if (isset($data['txn_date'], $data['iin'], $data['Num_d'], $data['type_doc'], $data['text_doc'])) {
                $this->result = $this->client->Zayavka($data);
            }
        }
        return $this;
    }

    public function _toArray()
    {
        if (isset($this->result->return)) {
            $xml = simplexml_load_string($this->result->return);

            $json = json_encode($xml);

            return [
                'code' => 200,
                'data' => json_decode($json, true)
            ];
        }

        return ['code' => 500, 'Ошибка при получении данных'];
    }
}
