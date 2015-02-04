<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*configuration */
$GLOBALS['numOfTries'] = 0; 
$GLOBALS['changeIpCommand'] = '"C:\Program Files (x86)\HMA! Pro VPN\bin\HMA! Pro VPN.exe" -changeip';
$GLOBALS['connectCommand'] = '"C:\Program Files (x86)\HMA! Pro VPN\bin\HMA! Pro VPN.exe" -connect';
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

                /*lets do a search*/
                $result = $searchMobile->getMobileNumberInformation();// fetch current status
                
                //check current credit , 
                while (!$this->checkCredit($searchMobile->getLastQueryContent())) {
                    exec($GLOBALS['changeIpCommand']);
                    exec($GLOBALS['connectCommand']);
                    echo "Changing IP Address \n";
                    sleep(30);
                    $result = $searchMobile->getMobileNumberInformation();//fetch aagain
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
    /**
     * Checks whether we still have credits or not
     * @param  [type] $mobileNumber [description]
     * @return [type]               [description]
     */
    private function checkCredit($rawContentQuery)
    {
        echo "Checking credits \n";
        $hasCredit = false;
        if (!empty($rawContentQuery)) {
            $tempResult = json_decode($rawContentQuery);
            if (isset($tempResult->status) && $tempResult->status !== "FAIL") {
                $hasCredit = true;
            }        
        }
        return $hasCredit;
    }


}
