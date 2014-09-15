<?php

/**
 * This is the model class for table "his_major".
 *
 * The followings are the available columns in table 'his_major':
 * @property integer $id
 * @property string $description
 * @property integer $dgu_id
 * @property integer $majorType_id
 * @property integer $catalog_id
 * @property integer $identifier_id
 *
 * The followings are the available model relations:
 * @property CurrDgu $dgu
 * @property CurrMajorType $majorType
 * @property Catalog $catalog
 * @property CurrMajor $identifier
 */
class HisMajor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HisMajor the static model class
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
		return 'his_major';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dgu_id, majorType_id', 'required'),
			array('id, dgu_id, majorType_id, catalog_id, identifier_id', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, description, dgu_id, majorType_id, catalog_id, identifier_id', 'safe', 'on'=>'search'),
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
			'dgu' => array(self::BELONGS_TO, 'CurrDgu', 'dgu_id'),
			'majorType' => array(self::BELONGS_TO, 'CurrMajorType', 'majorType_id'),
			'catalog' => array(self::BELONGS_TO, 'Catalog', 'catalog_id'),
			'identifier' => array(self::BELONGS_TO, 'CurrMajor', 'identifier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'description' => 'Description',
			'dgu_id' => 'Dgu',
			'majorType_id' => 'Major Type',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('dgu_id',$this->dgu_id);
		$criteria->compare('majorType_id',$this->majorType_id);
		$criteria->compare('catalog_id',$this->catalog_id);
		$criteria->compare('identifier_id',$this->identifier_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}