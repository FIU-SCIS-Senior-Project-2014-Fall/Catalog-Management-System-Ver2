<?php

/**
 * This is the model class for table "flow_group".
 *
 * The followings are the available columns in table 'flow_group':
 * @property integer $id
 * @property integer $flowchartid
 * @property integer $groupid
 * @property integer $trackid
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property FlowChart $flowchart
 * @property FlowSet $group
 * @property CurrTrack $track
 */
class FlowGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FlowGroup the static model class
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
		return 'flow_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('flowchartid, groupid, trackid, position', 'required'),
			array('flowchartid, groupid, trackid, position', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, flowchartid, groupid, trackid, position', 'safe', 'on'=>'search'),
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
			'flowchart' => array(self::BELONGS_TO, 'FlowChart', 'flowchartid'),
			'group' => array(self::BELONGS_TO, 'FlowSet', 'groupid'),
			'track' => array(self::BELONGS_TO, 'CurrTrack', 'trackid'),
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
			'groupid' => 'Groupid',
			'trackid' => 'Trackid',
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
		$criteria->compare('groupid',$this->groupid);
		$criteria->compare('trackid',$this->trackid);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}