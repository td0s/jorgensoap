<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use BeSimple\SoapClient\SoapClient AS SoapClient;
use BeSimple\SoapClient\SoapRequest AS SoapRequest;



class SoliditetSoapController extends BaseController
{
    //
    function getReport(){
        echo 'here';
        //if($request->isMethod('post')){
            $simpleClient = new SoapClient('https://webservice.soliditet.se/brg/services/NBKReportServiceSmall?wsdl');

            $identity = new \stdClass();
            $identity->user = env('APP_USERNAME');
            $identity->password = env('APP_PASSWORD');

            $includeEmptyFields = new \SoapHeader('brg','includeEmptyFields','true', false);
            $includeFieldDisplayName = new \SoapHeader('brg','includeFieldDisplayName','true', false);
            $fieldDisplayNameLanguage = new \SoapHeader('brg','fieldDisplayNameLanguage','sv', false);

            $simpleClient->__setSoapHeaders(array($includeEmptyFields,$includeFieldDisplayName,$fieldDisplayNameLanguage));


            $nBKReportServiceSmallRequest = new \stdClass;
            $nBKReportServiceSmallRequest->identity = $identity;

            $nBKVar = new \SoapVar($nBKReportServiceSmallRequest, SOAP_ENC_OBJECT, 'nBKReportServiceSmallRequest');

            return $simpleClient->__doRequest($nBKVar, 'https://webservice.soliditet.se/brg/services/NBKReportServiceSmall', 'request', '1' );





        }
   // }
}
