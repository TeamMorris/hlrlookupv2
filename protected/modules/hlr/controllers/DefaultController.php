<?php

class DefaultController extends Controller {

    public function actionIndex() {
        Yii::import("application.modules.hlr.components.*");
        $model = new SearchHLR;
        $resultQuery = array(
            "status"=>null,
            "message"=>null,
            "data"=>null,
        );
        if (isset($_POST['SearchHLR'])) {
            $model->mobileNumber  = $_POST['SearchHLR']['mobileNumber'];
            if ($model->validate()) {
                $lookupService = new HLRLookupService;
                $lookupService->setMobileNumber($model->mobileNumber);
                $result = $lookupService->getPhoneInformation();
                $resultQuery = array(
                    "status"=>"success",
                    "message"=>"Record found",
                    "data"=>$result,
                );

            } else {
                $resultQuery = array(
                    "status" => "error",
                    'message' => "Invald phone number format",
                    'data' => null,
                );
            }
        }
        $this->render('index' , array('resultQuery'=>$resultQuery , 'model'=>$model)  );
    }

}
