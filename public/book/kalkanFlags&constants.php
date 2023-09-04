<?php
        $KCST_PKCS12 = 0x1;
        $KCST_KZIDCARD = 0x2;
        $KCST_KAZTOKEN = 0x4;
        $KCST_ETOKEN72K  = 0x8;
        $KCST_JACARTA  = 0x10;
        $KCST_X509CERT = 0x20;
        $KCST_AKEY = 0x40;


        $KC_CERT_CA = 0x201;
        $KC_CERT_INTERMEDIATE = 0x202;
        $KC_CERT_USER = 0x204;


        $KC_CERT_DER  = 0x101;
        $KC_CERT_PEM  = 0x102;
        $KC_CERT_B64  = 0x104;


        $KC_USE_NOTHING = 0x401;
        $KC_USE_CRL = 0x402;
        $KC_USE_OCSP  = 0x404;


        $KC_CERTPROP_ISSUER_COUNTRYNAME = 0x801;
        $KC_CERTPROP_ISSUER_SOPN  = 0x802;
        $KC_CERTPROP_ISSUER_LOCALITYNAME  = 0x803;
        $KC_CERTPROP_ISSUER_ORG_NAME  = 0x804;
        $KC_CERTPROP_ISSUER_ORGUNIT_NAME  = 0x805;
        $KC_CERTPROP_ISSUER_COMMONNAME  = 0x806;
        $KC_CERTPROP_SUBJECT_COUNTRYNAME  = 0x807;
        $KC_CERTPROP_SUBJECT_SOPN = 0x808;
        $KC_CERTPROP_SUBJECT_LOCALITYNAME = 0x809;
        $KC_CERTPROP_SUBJECT_COMMONNAME = 0x80a;
        $KC_CERTPROP_SUBJECT_GIVENNAME  = 0x80b;
        $KC_CERTPROP_SUBJECT_SURNAME  = 0x80c;
        $KC_CERTPROP_SUBJECT_SERIALNUMBER = 0x80d;
        $KC_CERTPROP_SUBJECT_EMAIL  = 0x80e;
        $KC_CERTPROP_SUBJECT_ORG_NAME = 0x80f;
        $KC_CERTPROP_SUBJECT_ORGUNIT_NAME = 0x810;
        $KC_CERTPROP_SUBJECT_BC = 0x811;
        $KC_CERTPROP_SUBJECT_DC = 0x812;
        $KC_CERTPROP_NOTBEFORE  = 0x813;
        $KC_CERTPROP_NOTAFTER = 0x814;
        $KC_CERTPROP_KEY_USAGE  = 0x815;
        $KC_CERTPROP_EXT_KEY_USAGE  = 0x816;
        $KC_CERTPROP_AUTH_KEY_ID  = 0x817; 
        $KC_CERTPROP_SUBJ_KEY_ID  = 0x818;
        $KC_CERTPROP_CERT_SN  = 0x819;
        $KC_CERTPROP_ISSUER_DN  = 0x81a;
        $KC_CERTPROP_SUBJECT_DN = 0x81b;
        $KC_CERTPROP_SIGNATURE_ALG  = 0x81c;


        $KC_SIGN_DRAFT  = 0x1;
        $KC_SIGN_CMS  = 0x2;
        $KC_IN_PEM  = 0x4;
        $KC_IN_DER  = 0x8;
        $KC_IN_BASE64 = 0x10;
        $KC_IN2_BASE64  = 0x20;
        $KC_DETACHED_DATA = 0x40;
        $KC_WITH_CERT = 0x80;
        $KC_WITH_TIMESTAMP  = 0x100;
        $KC_OUT_PEM = 0x200;
        $KC_OUT_DER = 0x400;
        $KC_OUT_BASE64  = 0x800;
        
        $KC_PROXY_OFF = 0x00001000;
        $KC_PROXY_ON = 0x00002000;
        $KC_PROXY_AUTH = 0x00004000;



        $KCR_OK = 0;
        $KCR_INIT_ERROR = 0x8f00001;
        $KCR_ERROR_READ_PKCS12  = 0x8f00002;
        $KCR_ERROR_OPEN_PKCS12  = 0x8f00003;
        $KCR_INVALID_PROPID = 0x8f00004;
        $KCR_BUFFER_TOO_SMALL = 0x8f00005;
        $KCR_CERT_PARSE_ERROR = 0x8f00006;
        $KCR_INVALID_FLAG = 0x8f00007;
        $KCR_OPENFILEERR  = 0x8f00008;
        $KCR_INVALIDPASSWORD  = 0x8f00009;
        $KCR_CERTWRONGDATE  = 0x8f0000a;
        $KCR_CERTEXPIRED  = 0x8f0000b;
        $KCR_ISNOTCACERT  = 0x8f0000c;
        $KCR_MEMORY_ERROR = 0x8f0000d;
        $KCR_CHECKCHAINERROR  = 0x8f0000e;
        $KCR_CACERTKEYUSAGEERROR  = 0x8f0000f;
        $KCR_VALIDTYPEERROR = 0x8f00010;
        $KCR_BADCRLFORMAT = 0x8f00011;
        $KCR_LOADCRLERROR = 0x8f00012;
        $KCR_LOADCRLSERROR  = 0x8f00013;
        $KCR_UNKNOWN_ALG  = 0x8f00015;
        $KCR_KEYNOTFOUND  = 0x8f00016;
        $KCR_SIGN_INIT_ERROR  = 0x8f00017;
        $KCR_SIGN_ERROR = 0x8f00018;
        $KCR_ENCODE_ERROR = 0x8f00019;
        $KCR_INVALID_FLAGS  = 0x8f0001a;
        $KCR_CERTNOTFOUND = 0x8f0001b;
        $KCR_VERIFYSIGNERROR  = 0x8f0001c;
        $KCR_BASE64_DECODE_ERROR  = 0x8f0001d;
        $KCR_UNKNOWN_CMS_FORMAT = 0x8f0001e;
        $KCR_GETHASHERROR = 0x8f0001f;
        $KCR_CA_CERT_NOT_FOUND  = 0x8f00020;
        $KCR_XMLSECINIT_ERROR = 0x8f00021;
        $KCR_LOADTRUSTEDCERTSERR  = 0x8f00022;
        $KCR_SIGN_INVALID = 0x8f00023;
        $KCR_NOSIGNFOUND  = 0x8f00024;
        $KCR_DECODE_ERROR = 0x8f00025;
        $KCR_XMLPARSEERROR  = 0x8f00026;
        $KCR_XMLADDIDERROR  = 0x8f00027;
        $KCR_XMLINTERNALERROR = 0x8f00028;
        $KCR_XMLSETSIGNERROR  = 0x8f00029;
        $KCR_OPENSSLERROR = 0x8f0002a;
        $KCR_ENGINE_INITERR = 0x8f0002b;
        $KCR_NOTOKENFOUND = 0x8f0002c;
        $KCR_OCSP_ADDCERTERR  = 0x8f0002d;
        $KCR_OCSP_PARSEURLERR = 0x8f0002e;
        $KCR_OCSP_ADDHOSTERR  = 0x8f0002f;
        $KCR_OCSP_REQERR  = 0x8f00030;
        $KCR_OCSP_CONNECTIONERR = 0x8f00031;
        $KCR_VERIFY_NODATA  = 0x8f00032;
        $KCR_IDATTR_NOTFOUND  = 0x8f00033;
        $KCR_IDRANGE  = 0x8f00034;
        $KCR_XMLKEYDUPERROR = 0x8f00035;
        $KCR_XMLKEYCREATEERROR  = 0x8f00036;
        $KCR_READERNOTFOUND = 0x8f00037;
        $KCR_GETCERTPROPERR = 0x8f00038;
        $KCR_SIGNFORMMAT  = 0x8f00039;
        $KCR_INDATAFORMAT = 0x8f0003a;
        $KCR_OUTDATAFORMAT  = 0x8f0003b;
        $KCR_VERIFY_INIT_ERROR  = 0x8f0003c;
        $KCR_VERIFY_ERROR = 0x8f0003d;
        $KCR_HASH_ERROR = 0x8f0003e;
        $KCR_SIGNHASH_ERROR = 0x8f0003f;
        $KCR_CACERTNOTFOUND = 0x8f00040;
        $KCR_CERTTIMEINVALID  = 0x8f00042;
        $KCR_CONVERTERROR = 0x8f00043;
        $KCR_LIBRARYNOTINITIALIZED  = 0x8f00101;
        $KCR_ENGINELOADERR  = 0x8f00200;
        $KCR_PARAM_ERROR  = 0x8f00300;
        $KCR_CERT_STATUS_OK = 0x8f00400;
        $KCR_CERT_STATUS_REVOKED  = 0x8f00401;
        $KCR_CERT_STATUS_UNKNOWN  = 0x8f00402;


 $kalkanFlags = 0x0;
 
  if($outputData == "outBase64")
  {
    $kalkanFlags +=  $KC_OUT_BASE64;
  }
  elseif($outputData == "outPEM")
  {
    $kalkanFlags +=  $KC_OUT_PEM;
  }
  elseif($outputData == "outDER")
  {
    $kalkanFlags +=  $KC_OUT_DER;
  }

 
  if($inputData == "inBase64")
  {
    $kalkanFlags +=  $KC_IN_BASE64;
  }
  elseif($inputData == "inPEM")
  {
    $kalkanFlags +=  $KC_IN_PEM;
  }
  elseif($inputData == "inDER")
  {
    $kalkanFlags +=  $KC_IN_DER;
  }

  if($in2Base64 == 1)
  {
    $kalkanFlags +=  $KC_IN2_BASE64;
  }
  if($VDraftSign == 1)
  {
  	$kalkanFlags +=  $KC_SIGN_DRAFT;
  }
  else
  {
  	$kalkanFlags +=  $KC_SIGN_CMS;
  }
  if($detachedSign == 1)
  {
    $kalkanFlags +=  $KC_DETACHED_DATA;
  }
  if($addTimeStamp == 1)
  {
  	$kalkanFlags +=  $KC_WITH_TIMESTAMP;
  }

?>