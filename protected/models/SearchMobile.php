<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchMobile
 *
 * @author EMAXX-A55-FM2
 */
class SearchMobile extends CFormModel {

    public $mobileNumber;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('mobileNumber', 'required'),
        );
    }

    public function attributeLabels() {
        return array(
            'mobileNumber' => 'Mobile number',
        );
    }

    /**
     * 
     * @return array 
     */
    public function getMobileNumberInformation() {
        Yii::import("application.modules.hlr.components.*");
        $tempDataPath = Yii::getPathOfAlias("application.data");
        $tempFile = tempnam($tempDataPath, "curl_res");

        $lookupService = new HLRLookupService();
        $lookupService->setMobileNumber($this->mobileNumber);
        $resultArr = $lookupService->getPhoneInformation();

        // prepare command 
        $url = 'http://www.qas.co.uk/proweb/MobileNumberValidationServlet?';
        $getParams = array(
            'serviceId' => 'uk',
            'mobileNumber' => $this->mobileNumber,
            'format' => 'JSON',
        );
        $headers = array(
            "DNT: 1",
            "Accept-Language: en-US,en;q=0.8,fil;q=0.6,th;q=0.4,it;q=0.2,es;q=0.2",
            "User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.65 Safari/537.36",
            "Accept: application/json, text/javascript, */*; q=0.01",
            "X-Requested-With: XMLHttpRequest",
            "Connection: keep-alive",
        );
        $url = $url . http_build_query($getParams);
        $curl = curl_init($url);
        // curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $responseText = curl_exec($curl);
        $resultStatus = curl_getinfo($curl);
        curl_close($curl);
        $tempResultArr = json_decode($responseText, true);
        $resultArr['isActive'] = ($tempResultArr['response']['mobileNumber']['description'] !== "Unknown") ? true : false;
        return $resultArr;
    }

}
