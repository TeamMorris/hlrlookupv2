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
        $command = sprintf('curl "http://www.qas.co.uk/proweb/MobileNumberValidationServlet?serviceId=uk&mobileNumber=%s&format=JSON" -H "DNT: 1" -H "Accept-Encoding: gzip, deflate, sdch" -H "Accept-Language: en-US,en;q=0.8,fil;q=0.6,th;q=0.4,it;q=0.2,es;q=0.2" -H "User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.65 Safari/537.36" -H "Accept: application/json, text/javascript, */*; q=0.01" -H "X-Requested-With: XMLHttpRequest" -H "Connection: keep-alive" --compressed', $this->mobileNumber);
        exec("$command > $tempFile"); //execute curl command  , native command via exec
        $jsonContents = file_get_contents($tempFile);
        $tempResultArr = json_decode($jsonContents,true);
        $resultArr['isActive'] = ($tempResultArr['response']['mobileNumber']['description'] !== "Unknown") ? true:false;
        unlink($tempFile);
        return $resultArr;
    }

}
