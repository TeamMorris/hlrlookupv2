<?php

/**
 * Description of HLRLookupService
 *
 * @author EMAXX-A55-FM2
 */
class HLRLookupService {

    private $rawResult = '';
    private $mobileNumber = '';

    public function requestData() {
        $url = 'https://www.hlrcheck.com/freecheck';
        $getParams = array(
            'tocheck' => $this->mobileNumber
        );
        $headers = array(
            "Origin: https://www.hlrcheck.com",
            // "Accept-Encoding: gzip, deflate" ,
            "Accept-Language: en-US,en;q=0.8,fil;q=0.6,th;q=0.4,it;q=0.2,es;q=0.2",
            "User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.65 Safari/537.36",
            "Content-Type: application/x-www-form-urlencoded",
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
            "Cache-Control: max-age=0",
            "Referer: https://www.hlrcheck.com/freecheck",
            "Connection: keep-alive",
            "DNT: 1",
        );
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $getParams);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $responseText = curl_exec($curl);
        print_r($responseText);
        die();
        $resultStatus = curl_getinfo($curl);
        curl_close($curl);
        $this->setRawResult($responseText);
    }

    public function setRawResult($rawResult) {
        $this->rawResult = $rawResult;
    }

    public function getRawResult() {
        return $this->rawResult;
    }

    public function setMobileNumber($mobileNumber) {
        $this->mobileNumber = $mobileNumber;
    }

    public function getMobileNumber() {
        return $this->mobileNumber;
    }

    public function getPhoneInformation() {
        $this->requestData();
        $commandResult = $this->getRawResult();
        $htmlResult = \SimpleHtmlDom\str_get_html($commandResult);
        $resultMobileNumber = $htmlResult->find('//*[@id="slideme"]/tbody/tr[1]/td[2]', 0);
        $resultLocation = $htmlResult->find('//*[@id="slideme"]/tbody/tr[3]/td[2]', 0);
        $resultRegion = $htmlResult->find('//*[@id="slideme"]/tbody/tr[4]/td[2]', 0);
        $resultOriginalNetwork = $htmlResult->find('//*[@id="slideme"]/tbody/tr[5]/td[2]', 0);
        $resultTimezone = $htmlResult->find('//*[@id="slideme"]/tbody/tr[6]/td[2]', 0);
        $resultJson = array(
            "mobileNumber" => $this->cleanData($resultMobileNumber->plaintext),
            "location" => $this->cleanData($resultLocation->plaintext),
            "region" => $this->cleanData($resultRegion->plaintext),
            "originalNetwork" => $this->cleanData($resultOriginalNetwork->plaintext),
            "timeZone" => $this->cleanData($resultTimezone->plaintext),
        );
        return $resultJson;
    }

    public function cleanData($rawData) {
        $rawData = trim($rawData);
        return $rawData;
    }

}
