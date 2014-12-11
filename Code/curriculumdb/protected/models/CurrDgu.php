<?php

/**
 * This is the model class for table "curr_dgu".
 *
 * The followings are the available columns in table 'curr_dgu':
 * @property integer $id
 * @property string $name
 * @property integer $lastActivated_catalogId
 *
 * The followings are the available model relations:
 * @property CurrMajor[] $currMajors
 * @property HisDgu[] $hisDgus
 */
class CurrDgu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CurrDgu the static model class
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
		return 'curr_dgu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, lastActivated_catalogId', 'safe', 'on'=>'search'),
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
			'currMajors' => array(self::HAS_MANY, 'CurrMajor', 'dgu_id'),
			'hisDgus' => array(self::HAS_MANY, 'HisDgu', 'identifier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'lastActivated_catalogId' => 'Last Activated Catalog',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('lastActivated_catalogId',$this->lastActivated_catalogId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}