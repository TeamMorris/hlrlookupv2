<?php

class DefaultController extends Controller {

    public function actionIndex() {
        $uploadedFile = CUploadedFile::getInstanceByName("mobileNumbersCsv");
        if ($uploadedFile){
            //prepare upload path
            $uploadFilePath = Yii::getPathOfAlias("application.data");
            $tempFileName = tempnam($uploadFilePath, "queue_file");
            $uploadedFile->saveAs($tempFileName);
            //create queue file 
            $queue = new Queue();
            $queue->fileLocation = $tempFileName;
            $queue->queue_name = $uploadedFile->name;
            if($queue->save()){// save 
                // inform user that the file is queued , and pass the reference of that queue
                $referenceLinkUrl = Yii::app()->createUrl("queue/status",array("queueid"=> $queue->queue_id ));
                $referenceLink = CHtml::link("Reference Link", $referenceLinkUrl);
                Yii::app()->user->setFlash('success', '<strong>File Queued!</strong> Here is your reference link.'.$referenceLink );
            }else{
                Yii::app()->user->setFlash('error', '<strong>Error found!</strong> '.CHtml::errorSummary($queue));
            }
        }
        $this->render('index');
    }
}
