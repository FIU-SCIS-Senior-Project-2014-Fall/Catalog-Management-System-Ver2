<?php

/**
 * This is the model class for table "flow_set".
 *
 * The followings are the available columns in table 'flow_set':
 * @property integer $id
 * @property integer $flowchartid
 * @property integer $groupid
 * @property integer $setid
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property FlowChart $flowchart
 * @property CurrSet $set
 * @property CurrGroup $group
 */
class FlowSet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FlowSet the static model class
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
		return 'flow_set';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('flowchartid, groupid, setid, position', 'required'),
			array('flowchartid, groupid, setid, position', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, flowchartid, groupid, setid, position', 'safe', 'on'=>'search'),
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
			'set' => array(self::BELONGS_TO, 'CurrSet', 'setid'),
			'group' => array(self::BELONGS_TO, 'CurrGroup', 'groupid'),
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
			'setid' => 'Setid',
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
		$criteria->compare('setid',$this->setid);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}