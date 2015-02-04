<?php

class QueueController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'status','download','requeue'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionStatus() {


        if (isset($_GET['queueid'])) {
            $queue_id = intval($_GET['queueid']);
            $queue = Queue::model()->findByPk($queue_id);
            if ($queue) {
                $model=new MobileNumberRecord('search');
                $model->unsetAttributes();
                $model->queue_id = $queue_id;  // clear any default values
                if(isset($_GET['MobileNumberRecord'])){
                    $model->attributes=$_GET['MobileNumberRecord'];
                }
                $this->render("status",array('queue_model'=>$queue,'mobileModel'=>$model));
            } else {
                $this->redirect("index");
            }
        } else {
            $this->redirect("index");
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Queue;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Queue'])) {
            $model->attributes = $_POST['Queue'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->queue_id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Queue'])) {
            $model->attributes = $_POST['Queue'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->queue_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionDownload()
    {
        if (isset($_GET['queue_id']) ) {
            $getNameCommand = Yii::app()->db->createCommand("select * from queue where queue_id = :queue_id");
            $getNameCommand->params = array(
              "queue_id"=>intval($_GET['queue_id']),
            );            
            $nameRes = $getNameCommand->queryAll();
            $fileName = $nameRes[0]['queue_name'];
            $mobileStatus = isset($_GET['status']) ? $_GET['status']:"Active";

            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=$mobileStatus-mobile-numbers-$fileName.csv");
            header("Pragma: no-cache");
            header("Expires: 0");

            $command = Yii::app()->db->createCommand("select mobileNumber,location,region,originalNetwork,timezone,status,date_created as 'date processed' from mobilenumberrecord where queue_id = :queue_id and status = :status");
            $command->params = array(
              "queue_id"=>intval($_GET['queue_id']),
              "status"=>$mobileStatus,
            );
            $headersCsv = array(
                "mobileNumber ",
                "location",
                "region",
                "originalNetwork",
                "timezone",
                "status",
                "date processed",
            );
            $downloadResult = $command->queryAll();
            echo implode(",", $headersCsv)."\n";
            foreach ($downloadResult as $currentRow) {
                $currentRow = array_map('trim', $currentRow);
                echo implode(",", $currentRow)."\n";
            }
        }
    }
    public function actionRequeue()
    {
      if ($_GET['queue_id']) {
        $currentQueue = Queue::model()->findByPk($_GET['queue_id']);
        $currentQueue->queue_status = 'requeued';
        $currentQueue->save();
        Yii::app()->user->setFlash('success', '<strong>'.$currentQueue->queue_name.' requeued!</strong> Please re run rub.bat to resume HLR lookup.');
      }else{
        Yii::app()->user->setFlash('error', '<strong>Incomplete parameter!</strong> Woah cowboy , you forgot the queue_id .');
      }
      $this->render('requeue');
    }


    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->layout = '//layouts/column1';
        $dataProvider = new CActiveDataProvider('Queue');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Queue('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Queue']))
            $model->attributes = $_GET['Queue'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Queue the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Queue::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Queue $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'queue-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
