<?php

/**
 * This is the model class for table "his_course".
 *
 * The followings are the available columns in table 'his_course':
 * @property integer $id
 * @property integer $coursePrefix_id
 * @property integer $number
 * @property string $abstract
 * @property integer $credits
 * @property string $notes
 * @property integer $catalog_id
 * @property integer $identifier_id
 *
 * The followings are the available model relations:
 * @property CurrCourse $identifier
 * @property Catalog $catalog
 * @property HisRequisite[] $hisRequisites
 */
class HisCourse extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HisCourse the static model class
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
		return 'his_course';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('coursePrefix_id, number, credits, abstract, catalog_id', 'required'),
			array('coursePrefix_id, number, credits, catalog_id, identifier_id', 'numerical', 'integerOnly'=>true),
			array('abstract, notes', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, coursePrefix_id, number, abstract, credits, notes, catalog_id, identifier_id', 'safe', 'on'=>'search'),
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
			'identifier' => array(self::BELONGS_TO, 'CurrCourse', 'identifier_id'),
			'catalog' => array(self::BELONGS_TO, 'Catalog', 'catalog_id'),
			'hisRequisites' => array(self::HAS_MANY, 'HisRequisite', 'course_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'coursePrefix_id' => 'Course Prefix',
			'number' => 'Number',
			'abstract' => 'Abstract',
			'credits' => 'Credits',
			'notes' => 'Notes',
			'catalog_id' => 'Catalog',
			'identifier_id' => 'Identifier',
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
		$criteria->compare('coursePrefix_id',$this->coursePrefix_id);
		$criteria->compare('number',$this->number);
		$criteria->compare('abstract',$this->abstract,true);
		$criteria->compare('credits',$this->credits);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('catalog_id',$this->catalog_id);
		$criteria->compare('identifier_id',$this->identifier_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}