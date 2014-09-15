<?php

/**
 * This is the model class for table "his_track".
 *
 * The followings are the available columns in table 'his_track':
 * @property integer $id
 * @property string $description
 * @property integer $minCredits
 * @property integer $catalog_id
 * @property integer $identifier_id
 *
 * The followings are the available model relations:
 * @property CurrTrack $identifier
 * @property Catalog $catalog
 */
class HisTrack extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HisTrack the static model class
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
		return 'his_track';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('id, catalog_id', 'required'),
			array('id, minCredits, catalog_id, identifier_id', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, description, minCredits, catalog_id, identifier_id', 'safe', 'on'=>'search'),
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
			'identifier' => array(self::BELONGS_TO, 'CurrTrack', 'identifier_id'),
			'catalog' => array(self::BELONGS_TO, 'Catalog', 'catalog_id'),
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
			'minCredits' => 'Min Credits',
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
		$criteria->compare('minCredits',$this->minCredits);
		$criteria->compare('catalog_id',$this->catalog_id);
		$criteria->compare('identifier_id',$this->identifier_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}