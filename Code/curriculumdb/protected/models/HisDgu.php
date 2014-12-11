<?php

/**
 * This is the model class for table "his_dgu".
 *
 * The followings are the available columns in table 'his_dgu':
 * @property integer $id
 * @property string $description
 * @property string $code
 * @property integer $catalog_id
 * @property integer $identifier_id
 *
 * The followings are the available model relations:
 * @property Catalog $catalog
 * @property CurrDgu $identifier
 * @property HisMajor[] $hisMajors
 */
class HisDgu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HisDgu2 the static model class
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
		return 'his_dgu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('', 'required'),
			array('id, catalog_id, identifier_id', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, description, code, catalog_id, identifier_id', 'safe', 'on'=>'search'),
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
			'catalog' => array(self::BELONGS_TO, 'Catalog', 'catalog_id'),
			'identifier' => array(self::BELONGS_TO, 'CurrDgu', 'identifier_id'),
			'hisMajors' => array(self::HAS_MANY, 'HisMajor', 'dgu_id'),
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
			'code' => 'Code',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('catalog_id',$this->catalog_id);
		$criteria->compare('identifier_id',$this->identifier_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}