<?php

/**
 * This is the model class for table "his_set".
 *
 * The followings are the available columns in table 'his_set':
 * @property integer $id
 * @property integer $minCredits
 * @property integer $maxCredits
 * @property integer $catalog_id
 * @property integer $identifier_id
 *
 * The followings are the available model relations:
 * @property CurrSet $identifier
 * @property Catalog $catalog
 */
class HisSet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HisSet the static model class
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
		return 'his_set';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, maxCredits, catalog_id', 'required'),
			array('id, minCredits, maxCredits, catalog_id, identifier_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, minCredits, maxCredits, catalog_id, identifier_id', 'safe', 'on'=>'search'),
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
			'identifier' => array(self::BELONGS_TO, 'CurrSet', 'identifier_id'),
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
			'minCredits' => 'Min Credits',
			'maxCredits' => 'Max Credits',
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
		$criteria->compare('minCredits',$this->minCredits);
		$criteria->compare('maxCredits',$this->maxCredits);
		$criteria->compare('catalog_id',$this->catalog_id);
		$criteria->compare('identifier_id',$this->identifier_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}