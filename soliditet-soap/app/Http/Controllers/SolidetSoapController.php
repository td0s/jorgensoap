<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use BeSimple\SoapClient\SoapClient AS SoapClient;
use BeSimple\SoapClient\SoapRequest AS SoapRequest;


class SolidetSoapController extends BaseController
{
    //
    function getReport($request){
        if($request->isMethod == 'post'){
            $simpleClient = new SoapClient('https://webservice.soliditet.se/brg/services/NBKReportServiceSmall?wsdl');

            $identity = new \stdClass();
            $identity->user = env('APP_USERNAME');
            $identity->password = env('APP_PASSWORD');

            $includeEmptyFields = new SoapHeader('brg','includeEmptyFields',TRUE, false);
            $includeFieldDisplayName = new SoapHeader('brg','includeFieldDisplayName',TRUE, false);
            $fieldDisplayNameLanguage = new SoapHeader('brg','fieldDisplayNameLanguage','SE', false);

            $simpleClient->__setSoapHeaders(array($includeEmptyFields,$includeFieldDisplayName,$fieldDisplayNameLanguage));


            $nBKReportServiceSmallRequest = new \stdClass;
            $nBKReportServiceSmallRequest->identity = $identity;


            $simpleRequest = new SoapRequest($nBKReportServiceSmallRequest, $request->input('location'), $request->input('action'), $request->input('version') );

        }
    }
}
