<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
            $mobileNumberCriteria = new CDbCriteria();
            $mobileNumberCriteria->compare("queue_id", $queue->queue_id);
            $mobileNumbers = MobileNumberRecord::model()->findAll($mobileNumberCriteria);
            $searchMobile = new SearchMobile();
            //Begin Lookup
            foreach ($mobileNumbers as $currentMobileNumbers) {
                /*
                 * @var $currentMobileNumbers MobileNumberRecord
                 */
                $searchMobile->mobileNumber = $currentMobileNumbers->mobileNumber;
                $result = $searchMobile->getMobileNumberInformation();
                $currentMobileNumbers->location = $result['location'];
                $currentMobileNumbers->region = $result['region'];
                $currentMobileNumbers->originalNetwork = $result['originalNetwork'];
                $currentMobileNumbers->timezone = $result['timeZone'];
                $currentMobileNumbers->status = $result['isActive'] ? "Active" : "Inactive";
                if ($currentMobileNumbers->save()) {
                    echo "Search lookup for : $currentMobileNumbers->mobileNumber : Succeed. \n";
                } else {
                    echo "Search lookup for : $currentMobileNumbers->mobileNumber : Failed. \n";
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

}
