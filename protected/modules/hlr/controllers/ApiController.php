<?php

/**
 * 
 */
class ApiController extends Controller {

    public function actionIndex() {
        if (Yii::app()->request->isPostRequest && isset($_POST['SearchHLR']['mobileNumber'])) {
        	$model = new SearchHLR;
        	$model->mobileNumber  = $_POST['SearchHLR']['mobileNumber'];
        	if ($model->validate()) {
        		header('Content-Type: application/json');
                $lookupService = new HLRLookupService;
                $lookupService->setMobileNumber($model->mobileNumber);
                $result = $lookupService->getPhoneInformation();
                echo json_encode($result);
        	}else{
        		throw new CHttpException(500, "Invalid mobile number format : ".$_POST['SearchHLR']['mobileNumber']);
        	}
            
        } else {
            throw new CHttpException(404, "Sorry we dont support that");
        }
    }

}
