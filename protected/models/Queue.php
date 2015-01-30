<?php

/**
 * This is the model class for table "queue".
 *
 * The followings are the available columns in table 'queue':
 * @property integer $queue_id
 * @property string $queue_name
 * @property string $fileLocation
 * @property string $queue_status
 * @property string $date_created
 * @property string $date_finished
 *
 * The followings are the available model relations:
 * @property Mobilenumberrecord[] $mobilenumberrecords
 */
class Queue extends CActiveRecord {

    public $queue_status = "queued"; // possible values [on-going , done]
    public $queue_name;
    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'queue';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fileLocation, queue_status,queue_name', 'length', 'max' => 255),
            array('date_created, date_finished', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('queue_id, queue_name,fileLocation, queue_status, date_created, date_finished', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'mobilenumberrecords' => array(self::HAS_MANY, 'Mobilenumberrecord', 'queue_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'queue_id' => 'Queue',
            'queue_name' => 'Queue Name',
            'fileLocation' => 'File Location',
            'queue_status' => 'Queue Status',
            'date_created' => 'Date Created',
            'date_finished' => 'Date Finished',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('queue_id', $this->queue_id);
        $criteria->compare('queue_name', $this->queue_name, true);
        $criteria->compare('fileLocation', $this->fileLocation, true);
        $criteria->compare('queue_status', $this->queue_status, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_finished', $this->date_finished, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Queue the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->date_created = date("Y-m-d H:i:s");
        }
        parent::beforeSave();
        return true;
    }

    public function getMobileNumbers() {
        //using queue_id , of mobile number
        $criteria = new CDbCriteria();
        $criteria->compare('queue_id', $this->queue_id);
        return MobileNumberRecord::model()->findAll($criteria);
    }

    /**
     * Get number of processed mobile numbers
     */
    public function getNumProcessedMobileNumbers(){
        $criteria = new CDbCriteria();
        $criteria->compare('queue_id', $this->queue_id);
        $criteria->addInCondition("status", array("Active" , "Inactive"));
        return MobileNumberRecord::model()->count($criteria);
    }

    /**
     * Get number of unprocessed mobile numbers
     */
    public function getNumUnprocessedMobileNumbers() {
        $criteria = new CDbCriteria();
        $criteria->compare('queue_id', $this->queue_id);
        $criteria->addNotInCondition("status", array("Active" , "Inactive"));
        return MobileNumberRecord::model()->count($criteria);
    }
    
}
