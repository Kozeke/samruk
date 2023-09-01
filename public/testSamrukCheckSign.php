<?php
include "kalkanFlags&constants.php";

KalkanCrypt_Init();
$flag_proxy = $KC_PROXY_AUTH;
$inProxyAddr = "192.168.39.241";
$inProxyPort = "9090";
$inUser = "";
$inPass = "";
$err = KalkanCrypt_SetProxy( $flag_proxy, $inProxyAddr, $inProxyPort, $inUser, $inPass);
//$tsaurl = "http://test.pki.gov.kz:80//tsp/";
$tsaurl = "http://test.pki.gov.kz/tsp/";
//$tsaurl = "http://tsp.pki.gov.kz:80";
KalkanCrypt_TSASetUrl($tsaurl);

$container = "../RSA256_d32dfe58255bb1a0ca95457e40c513f1c80ea51c.p12";

$password = "123456Aa";
$alias = "";
$storage = $KCST_PKCS12;
$err = KalkanCrypt_LoadKeyStore($storage, $password,$container,$alias);
if ($err > 0){	echo "Error:\tKalkanCrypt_LoadKeyStore".$err."\n";}
else{echo "Ok\tKalkanCrypt_LoadKeyStore\n";}

//$fd = fopen("output.txt", 'w') or die("не удалось создать файл");
$granica = "\n\n___________________________________________________________________________\n\n";

$outSign = "/home/d/file/signPDF_in_base64";
//$flags_verify = $KC_SIGN_CMS + $KC_IN_DER;
//$flags_sign = $KC_SIGN_CMS + $KC_IN_FILE + $KC_OUT_BASE64 ;

//$flag_getCertFromCMS = $flags_verify;
$inData = "/home/d/file/application.pdf";
$flags_number = 8;
$outData  = "";	$outVerifyInfo  = ""; $outCertCMS  = "";
$inData = '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';
$inSign = 'MIIGcjCCBFqgAwIBAgIUUy3+WCVbsaDKlUV+QMUT8cgOpRwwDQYJKoZIhvcNAQEL
BQAwUjELMAkGA1UEBhMCS1oxQzBBBgNVBAMMOtKw0JvQotCi0KvSmiDQmtCj05jQ
m9CQ0J3QlNCr0KDQo9Co0Ksg0J7QoNCi0JDQm9Cr0pogKFJTQSkwHhcNMjMwMTI1
MDMzMTMxWhcNMjQwMTI1MDMzMTMxWjCBkTEuMCwGA1UEAwwl0JrQo9Cg0JDQm9CR
0JDQldCS0JAg0JDQltCQ0KDQk9Cj0JvQrDEdMBsGA1UEBAwU0JrQo9Cg0JDQm9CR
0JDQldCS0JAxGDAWBgNVBAUTD0lJTjc0MDIyODQwMDk3MTELMAkGA1UEBhMCS1ox
GTAXBgNVBCoMENCQ0KHQkNCd0J7QktCd0JAwggEiMA0GCSqGSIb3DQEBAQUAA4IB
DwAwggEKAoIBAQCLnF3SA/2EyqRkoCd2/CNVtbD3FmYqIWYr5i2fZOlppezLIYUJ
471H0T3kl+NtBeoUpk47YvJHU/xJiJmyiF4H7ziPwFr2Hg6BXPzZY845Y/wyLk6k
bPd+rEJUlY+KKAe/YZEDuSZqBVRtyQp1n0uDEfy5yBeS+JnqzTfsYcm15bTHwWfc
+cqjRgvTxIUshhw9GoYgWB67jGZvXgJzi0i9HV+zMubZ8+XSteUCuA1VYAgJ/9C1
/9g3Yvu9HE0mxaP/4QCglCc6+tDTsvx9BZ1JGvaMXH/VxLInUcGHwstlQmaypznQ
vyUQqZDvDtuFxFrNCX0YJiAPsD7KUjZHOMIpAgMBAAGjggH+MIIB+jAOBgNVHQ8B
Af8EBAMCBsAwKAYDVR0lBCEwHwYIKwYBBQUHAwQGCCqDDgMDBAEBBgkqgw4DAwQD
AgEwXgYDVR0gBFcwVTBTBgcqgw4DAwIDMEgwIQYIKwYBBQUHAgEWFWh0dHA6Ly9w
a2kuZ292Lmt6L2NwczAjBggrBgEFBQcCAjAXDBVodHRwOi8vcGtpLmdvdi5rei9j
cHMwVgYDVR0fBE8wTTBLoEmgR4YhaHR0cDovL2NybC5wa2kuZ292Lmt6L25jYV9y
c2EuY3JshiJodHRwOi8vY3JsMS5wa2kuZ292Lmt6L25jYV9yc2EuY3JsMFoGA1Ud
LgRTMFEwT6BNoEuGI2h0dHA6Ly9jcmwucGtpLmdvdi5rei9uY2FfZF9yc2EuY3Js
hiRodHRwOi8vY3JsMS5wa2kuZ292Lmt6L25jYV9kX3JzYS5jcmwwYgYIKwYBBQUH
AQEEVjBUMC4GCCsGAQUFBzAChiJodHRwOi8vcGtpLmdvdi5rei9jZXJ0L25jYV9y
c2EuY2VyMCIGCCsGAQUFBzABhhZodHRwOi8vb2NzcC5wa2kuZ292Lmt6MB0GA1Ud
DgQWBBTTLf5YJVuxoMqVRX5AxRPxyA6lHDAPBgNVHSMECDAGgARbanQRMBYGBiqD
DgMDBQQMMAoGCCqDDgMDBQEBMA0GCSqGSIb3DQEBCwUAA4ICAQBpQ9EmvaIeqqjO
4HFxjE5/WymedBSCJnBoCx38yYW+1OeEfKtD9gocY76bc9RRYN2C3HDAHx/FX6SU
+MaeaX2dd6VVX8FOxwtNaS/KXrwVLq22MqBZmnwnNjL1H8ldHgiVTN+j2T3r7o00
w8ROdZai7fD5zGggIEe98/WdMiQUzOHfiktc68TZetyWJcb9poQJ3VJLzf3HDdJL
CsJdRT6l4Q7tSVIXuVRd8ct3bRgij0Sb+0PQJB2yAJz+suYXG21D7y6tsKe7WGzl
P7QmH9lGGh8oqqaD3mNvWc3mWugqM/OPs4krKUXkHEp7NLOUu43b4DKFkXMhjWMK
rr4Cxhi9yYVnWI5oAYfgsP55NWeap3sySTq+GNSpdP//o0t7jc/1le+JR+2x1/8/
LU92x3hofBBn+4jlq2k25zI1KZFKCcQbe6jVc3BoZ54Yw9AnuLCRQZvOWfgC/psA
UVn+vyIhBV1M7iBcVc3cjc2iVtbBercHiUuD5+VN/Ta0D6alsxQ2XS/Ko9XjgRO6
Ghq5v0YaXAy1T6bwUDuOCSUkO7N8+OK23vwN5CV/3ZQH9FyrHLn7XxwZZHyS7ThU
hu28r+UHTM248i/SLqMRPf2o8ZIdlWlzfGV9wGtQ/PCWTHErdoBGoseu0+KmMeTa
rfGUsswxMzXqAA85GGGEiVbBQb7olQ==';
$inSign = str_replace(PHP_EOL, '', $inSign);

//$flags_validate = $KC_USE_OCSP;
//$validPath = "http://test.pki.gov.kz/ocsp/";
//
//$outInfo = "";
//$getResp = "";
//$err = KalkanCrypt_X509ValidateCertificate($inSign, $flags_validate, $validPath, 0, $outInfo, $KC_NOCHECKCERTTIME, $getResp);
//
//if ($err > 0){
//    echo "Error: ".$err."\n";
//    print_r(KalkanCrypt_GetLastErrorString());
//}
//else{
//    echo "\n\n\n".$outInfo."\n";
//    echo "\n".$getResp."\n";
//}
$inSignID = 1;
$flags_sign = 582;
$outCert="";
$outSign = $inData;
$err = KalkanCrypt_getCertFromCMS($outSign, $inSignID, $flags_sign, $outCert);

if ($err > 0){
    echo "Error: ".$err."\n";
    print_r(KalkanCrypt_GetLastErrorString());
}
