<?php

/**
 * This is the model class for table "his_requisite".
 *
 * The followings are the available columns in table 'his_requisite':
 * @property integer $id
 * @property integer $course_id
 * @property integer $requisite_id
 * @property integer $level
 * @property integer $catalog_id
 *
 * The followings are the available model relations:
 * @property HisCourse $requisite
 * @property HisCourse $course
 */
class HisRequisite extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HisRequisite the static model class
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
		return 'his_requisite';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, course_id, requisite_id, level, catalog_id', 'required'),
			array('id, course_id, requisite_id, level, catalog_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, course_id, requisite_id, level, catalog_id', 'safe', 'on'=>'search'),
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
			'requisite' => array(self::BELONGS_TO, 'HisCourse', 'requisite_id'),
			'course' => array(self::BELONGS_TO, 'HisCourse', 'course_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'course_id' => 'Course',
			'requisite_id' => 'Requisite',
			'level' => 'Level',
			'catalog_id' => 'Catalog',
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
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('requisite_id',$this->requisite_id);
		$criteria->compare('level',$this->level);
		$criteria->compare('catalog_id',$this->catalog_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}