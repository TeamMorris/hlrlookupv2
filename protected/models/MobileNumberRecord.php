<?php

/**
 * This is the model class for table "mobilenumberrecord".
 *
 * The followings are the available columns in table 'mobilenumberrecord':
 * @property integer $rec_id
 * @property integer $queue_id
 * @property string $mobileNumber
 * @property string $location
 * @property string $region
 * @property string $originalNetwork
 * @property string $timezone
 * @property string $status
 * @property string $date_created
 * @property string $date_updated
 *
 * The followings are the available model relations:
 * @property Queue $queue
 */
class MobileNumberRecord extends CActiveRecord {
    public $status = "idle";// possible values [null,done]
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mobilenumberrecord';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mobileNumber', 'required'),
            array('queue_id', 'numerical', 'integerOnly' => true),
            array('mobileNumber, location, region, originalNetwork, timezone, status', 'length', 'max' => 255),
            array('date_created, date_updated', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rec_id, queue_id, mobileNumber, location, region, originalNetwork, timezone, status, date_created, date_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'queue' => array(self::BELONGS_TO, 'Queue', 'queue_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'rec_id' => 'Rec',
            'queue_id' => 'Queue',
            'mobileNumber' => 'Mobile Number',
            'location' => 'Location',
            'region' => 'Region',
            'originalNetwork' => 'Original Network',
            'timezone' => 'Timezone',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
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

        $criteria->compare('rec_id', $this->rec_id);
        $criteria->compare('queue_id', $this->queue_id);
        $criteria->compare('mobileNumber', $this->mobileNumber, true);
        $criteria->compare('location', $this->location, true);
        $criteria->compare('region', $this->region, true);
        $criteria->compare('originalNetwork', $this->originalNetwork, true);
        $criteria->compare('timezone', $this->timezone, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('date_updated', $this->date_updated, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MobileNumberRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        if($this->isNewRecord){
            $this->date_created = date("Y-m-d H:i:s");
        }
        $this->date_updated = date('Y-m-d H:i:s');
        parent::beforeSave();
        return true;
    }
    public function getNumActiveMobile($queue_id)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('queue_id', $queue_id);
        $criteria->addInCondition("status", array("Active"));
        return MobileNumberRecord::model()->count($criteria);
    }
    public function getNumInactiveMobile($queue_id)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('queue_id', $queue_id);
        $criteria->addInCondition("status", array("Inactive"));
        return MobileNumberRecord::model()->count($criteria);
    }

}
