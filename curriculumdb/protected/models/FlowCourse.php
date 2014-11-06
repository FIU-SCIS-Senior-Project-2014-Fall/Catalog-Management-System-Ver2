<?php

/**
 * This is the model class for table "flow_course".
 *
 * The followings are the available columns in table 'flow_course':
 * @property integer $id
 * @property integer $flowchartid
 * @property integer $courseid
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property FlowChart[] $flowCharts
 * @property HisCourse $course
 */
class FlowCourse extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FlowCourse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'flow_course';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('flowchartid, courseid, position', 'required'),
			array('flowchartid, courseid, position', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, flowchartid, courseid, position', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'flowCharts' => array(self::HAS_MANY, 'FlowChart', 'flowID'),
			'course' => array(self::BELONGS_TO, 'HisCourse', 'courseid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'flowchartid' => 'Flowchartid',
			'courseid' => 'Courseid',
			'position' => 'Position',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('flowchartid',$this->flowchartid);
		$criteria->compare('courseid',$this->courseid);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}