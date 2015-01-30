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
            $mobileNumberCriteria = new CDbCriteria();
            $mobileNumberCriteria->compare("queue_id", $queue->queue_id);

            $mobileNumbers = MobileNumberRecord::model()->find($mobileNumberCriteria);
            $searchMobile = new SearchMobile();
            //Begin Lookup
            while($mobileNumbers) {
                /*
                 * @var $currentMobileNumbers MobileNumberRecord
                 */
                $searchMobile->mobileNumber = $mobileNumbers->mobileNumber;
                $result = $searchMobile->getMobileNumberInformation();
                $mobileNumbers->location = $result['location'];
                $mobileNumbers->region = $result['region'];
                $mobileNumbers->originalNetwork = $result['originalNetwork'];
                $mobileNumbers->timezone = $result['timeZone'];
                $mobileNumbers->status = $result['isActive'] ? "Active" : "Inactive";
                if ($mobileNumbers->save()) {
                    echo "Search lookup for : $currentMobileNumbers->mobileNumber : Succeed. \n";
                } else {
                    echo "Search lookup for : $currentMobileNumbers->mobileNumber : Failed. \n";
                }
                $mobileNumbers = MobileNumberRecord::model()->find($mobileNumberCriteria);
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
