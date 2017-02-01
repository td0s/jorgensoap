<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use BeSimple\SoapClient\SoapClient AS SoapClient;
use BeSimple\SoapClient\SoapRequest AS SoapRequest;
use Illuminate\Http\Request;




class SoliditetSoapController extends BaseController
{
    //
    function getReport(Request $request)
    {
        //echo 'here';
        //if($request->isMethod('post')){
        $simpleClient = new SoapClient('https://webservice.soliditet.se/brg/services/NBKReportServiceSmall?wsdl', array('trace' => 1));

        $identity = new \stdClass();
        $identity->user = env('APP_USERNAME');
        $identity->password = env('APP_PASSWORD');
        //print_r($identity);

        $includeEmptyFields = new \SoapHeader('brg', 'includeEmptyFields', 'true', false);
        $includeFieldDisplayName = new \SoapHeader('brg', 'includeFieldDisplayName', 'true', false);
        $fieldDisplayNameLanguage = new \SoapHeader('brg', 'fieldDisplayNameLanguage', 'sv', false);
        //$userId = new \SoapHeader('brg','userId',env('APP_USERNAME'), false);
        //$userPassword = new \SoapHeader('brg','userPassword',env('APP_PASSWORD'), false);

        $simpleClient->__setSoapHeaders(array($includeEmptyFields, $includeFieldDisplayName, $fieldDisplayNameLanguage));


        $nBKReportServiceSmallRequest = new \stdClass;
        $nBKReportServiceSmallRequest->identity = $identity;

        $nBKReportServiceSmallRequest->contract = new \stdClass;

        $nBKReportServiceSmallRequest->reportCriteria = new \stdClass;
        $nBKReportServiceSmallRequest->reportCriteria->startPos = 0;
        $nBKReportServiceSmallRequest->reportCriteria->pageSize = 50;
        $nBKReportServiceSmallRequest->reportCriteria->numberOfHits = 500;
        $nBKReportServiceSmallRequest->reportCriteria->buyReport = false;
        $nBKReportServiceSmallRequest->reportCriteria->language = 'SV';

        $nBKReportServiceSmallRequest->reportCriteria->countries = new \stdClass;
        $nBKReportServiceSmallRequest->reportCriteria->countries->country = 'SE';

        $nBKReportServiceSmallRequest->reportCriteria->criteria = new \stdClass;
        $nBKReportServiceSmallRequest->reportCriteria->criteria->freetext = $request->input('freetext');


        $response = $simpleClient->service($nBKReportServiceSmallRequest);

        return 'Search text: '.$request->input('freetext').print_r($response);

    }

}
