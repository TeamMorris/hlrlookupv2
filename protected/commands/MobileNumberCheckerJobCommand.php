<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*configuration */
$GLOBALS['numOfTries'] = 0; 

/**
 * Description of MobileNumberCheckerJob
 *
 * @author EMAXX-A55-FM2
 */
class MobileNumberCheckerJobCommand extends CConsoleCommand {


    public function actionIndex() {
        Yii::import("application.modules.hlr.components.*");
        Yii::import("application.models.*");
        echo "Preparing Mobile Number Queue. \n";
        //get one queue from the database
        $criteria = new CDbCriteria();
        $criteria->compare("queue_status", "queued");
        //update the status to on-going
        /**
         * @var $queue Queue
         */
        $queue = Queue::model()->find($criteria);
        if ($queue) {
            //update queued to on-going
            $queue->queue_status = "on-going";
            $queue->save(false);
            //todo read file and insert to database
            $contents = file_get_contents($queue->fileLocation);
            $contentsArr = explode("\n", $contents);
            foreach ($contentsArr as $currentVal) {
                $tempMobileNumberContainer = explode(",", $currentVal);
                $newMobile = new MobileNumberRecord();
                $newMobile->mobileNumber = $tempMobileNumberContainer[0];
                $newMobile->queue_id = $queue->queue_id;
                if ($newMobile->save()) {
                    echo "New mobile number saved : $newMobile->mobileNumber \n";
                } else {
                    echo "New mobile number failed : $newMobile->mobileNumber :\n";
                    $errors = $newMobile->getErrors();
                    foreach($errors as $currentError){
                        echo $currentError."\n";
                    }
                }
            }
            echo "Starting lookup job . \n";
            /*retrieve all mobile numbners under the queue*/
            $mobileNumbersCommand = Yii::app()->db->createCommand("select mobileNumber from mobilenumberrecord where queue_id = :queue_id");
            $mobileNumbersCommand->params = array("queue_id" => $queue->queue_id );
            $mobileNumbersArrResult = $mobileNumbersCommand->queryAll();
            /*mobile info searcher */
            $searchMobile = new SearchMobile();
            //begin lookup
            foreach ($mobileNumbersArrResult as $index => $currentValue) {
                $currentIndex = $index+1;
                $result = "";

                $mobileNumberCriteria = new CDbCriteria();
                $mobileNumberCriteria->compare("queue_id", $queue->queue_id);
                $mobileNumberCriteria->compare("mobileNumber", $currentValue['mobileNumber']);
                $mobileNumbers = MobileNumberRecord::model()->find($mobileNumberCriteria);
                //set mobile number to search
                $searchMobile->mobileNumber = $mobileNumbers->mobileNumber;


                /*Check connection after changing ip address*/
                //check the data from  the HLR server if empty
                // if not empty continue , else re do it
                
                while (true) {
                    $result = "";
                    if ($this->checkConnection()) {
                        $result = @$searchMobile->getMobileNumberInformation();
                    }
                    
                    if (empty($result)) {
                        echo "Re check connection.... Number of tries : ".$GLOBALS['numOfTries']."\n";
                    }else{
                        $command = 'curl "http://api.phone-validator.net/api/v2/verify" -H "Origin: http://www.phone-validator.net" -H "Accept-Encoding: gzip, deflate" -H "Accept-Language: en-US,en;q=0.8,fil;q=0.6,th;q=0.4,it;q=0.2,es;q=0.2" -H "User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.65 Safari/537.36" -H "Content-Type: application/x-www-form-urlencoded; charset=UTF-8" -H "Accept: application/json, text/javascript, */*; q=0.01" -H "Referer: http://www.phone-validator.net/" -H "Connection: keep-alive" -H "DNT: 1" --data "PhoneNumber='.$mobileNumbers->mobileNumber.'&CountryCode=gb" --compressed';
                        $commandResult = exec($command);
                        $tempResult = "";
                        if (!empty($commandResult)) {
                            $tempResult = json_decode($commandResult);
                        }else{
                            continue;
                        }
                        if (isset($tempResult->status) && $tempResult->status === "FAIL") {
                            continue;
                        }else{
                            break;
                        }
                    }
                }

                
                $mobileNumbers->location = $result['location'];
                $mobileNumbers->region = $result['region'];
                $mobileNumbers->originalNetwork = $result['originalNetwork'];
                $mobileNumbers->timezone = $result['timeZone'];
                $mobileNumbers->status = $result['isActive'] ? "Active" : "Inactive";
                if ($mobileNumbers->save()) {
                    echo "Search lookup for : $mobileNumbers->mobileNumber : Succeed. \n";
                } else {
                    echo "Search lookup for : $mobileNumbers->mobileNumber : Failed. \n";
                }
            }
            $queue->queue_status = "done";
            $queue->date_finished = date("Y-m-d H:i:s");
            unlink($queue->fileLocation);
            $queue->save(false);
        } else {
            echo "Nothing to process. \n";
        }
    }

    /**
    *  Check connection , Returns false if no netowkr connection . else returns true. 
    *  If 5 tries and still fails to connect it will wait for 5 seconds before retrying again
    */
    private function checkConnection()
    {
        $isValid = false;
        $url = 'http://myexternalip.com/json';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $responseText = curl_exec($curl); 
        $resultStatus = curl_getinfo($curl);
        curl_close($curl);

        if (!empty($responseText)) {
            $responseTextArr = json_decode($responseText);
            if (!in_array($responseTextArr->ip, array("203.177.167.50","122.53.31.206"))) {
                $isValid = true;
                $GLOBALS['numOfTries'] = 0;
            }else{
                $GLOBALS['numOfTries'] = $GLOBALS['numOfTries']+1;
            }
        }else{
            $GLOBALS['numOfTries'] = $GLOBALS['numOfTries']+1;
        }
        //5 failed attempts maybe we should change ip address , 
        if ($GLOBALS['numOfTries'] == 5 ) {
            $GLOBALS['numOfTries'] = 0;
            sleep(1);
        }
        return $isValid;
    }    


}
