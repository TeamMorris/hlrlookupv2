<?php



/**
 * Description of HLRLookupService
 *
 * @author EMAXX-A55-FM2
 */
class HLRLookupService {

    private $rawResult = '';
    private $mobileNumber = '';
    private $tempFileName = '';
    
    public function __destruct() {
        unlink($this->tempFileName);
    }

    public function requestData($mobileNumber) {
        $commandResult = '';
        $temporaryFile = tempnam(__DIR__, "tempResult");
        $this->tempFileName = $temporaryFile;
        
        $command = sprintf('curl "https://www.hlrcheck.com/freecheck" -H "Origin: https://www.hlrcheck.com" -H "Accept-Encoding: gzip, deflate" -H "Accept-Language: en-US,en;q=0.8,fil;q=0.6,th;q=0.4,it;q=0.2,es;q=0.2" -H "User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.65 Safari/537.36" -H "Content-Type: application/x-www-form-urlencoded" -H "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8" -H "Cache-Control: max-age=0" -H "Referer: https://www.hlrcheck.com/freecheck" -H "Connection: keep-alive" -H "DNT: 1" --data "tocheck=%s" --compressed > %s ', $mobileNumber,$temporaryFile);
        exec($command);
        $commandResult = file_get_contents($temporaryFile);
        $this->setRawResult($commandResult);
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
        $this->requestData($this->getMobileNumber());
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

