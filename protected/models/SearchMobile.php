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
    private $lastQueryContent = '';

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
        $lookupService = new HLRLookupService();
        $lookupService->setMobileNumber($this->mobileNumber);
        $resultArr = $lookupService->getPhoneInformation();
        $resultArr['isActive'] = $this->isMobileActive($this->mobileNumber);
        return $resultArr;
    }
    private function isMobileActive($mobileNumber)
    {
        $isActive = false;
        $command = 'curl "http://api.phone-validator.net/api/v2/verify" -H "Origin: http://www.phone-validator.net" -H "Accept-Encoding: gzip, deflate" -H "Accept-Language: en-US,en;q=0.8,fil;q=0.6,th;q=0.4,it;q=0.2,es;q=0.2" -H "User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.65 Safari/537.36" -H "Content-Type: application/x-www-form-urlencoded; charset=UTF-8" -H "Accept: application/json, text/javascript, */*; q=0.01" -H "Referer: http://www.phone-validator.net/" -H "Connection: keep-alive" -H "DNT: 1" --data "PhoneNumber='.$mobileNumber.'&CountryCode=gb" --compressed';
        $commandResult = exec($command);
        $this->lastQueryContent = $commandResult;
        if (!empty($commandResult)) {
            $jsonResult = json_decode($commandResult);
            if (isset($jsonResult->status) && ($jsonResult->status !== "VALID_UNCONFIRMED")   && ($jsonResult->status == "VALID_ACTIVE") ) {
                $isActive = true;
            }
        }
        return $isActive;
    }
    public function getLastQueryContent(){
        return $this->lastQueryContent;
    }

}
