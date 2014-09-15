<?php

/**
 * This is the model class for table "curr_group".
 *
 * The followings are the available columns in table 'curr_group':
 * @property integer $id
 * @property string $name
 * @property integer $catalog_id
 *
 * The followings are the available model relations:
 * @property Catalog $catalog
 * @property CurrGroupSet[] $currGroupSets
 * @property CurrTrackGroup[] $currTrackGroups
 * @property HisGroup[] $hisGroups
 */
class CurrGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CurrGroup the static model class
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
		return 'curr_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, catalog_id', 'required'),
			array('catalog_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, catalog_id', 'safe', 'on'=>'search'),
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
			'currGroupSets' => array(self::HAS_MANY, 'CurrGroupSet', 'group_id'),
			'currTrackGroups' => array(self::HAS_MANY, 'CurrTrackGroup', 'group_id'),
			'hisGroups' => array(self::HAS_MANY, 'HisGroup', 'identifier_id'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('catalog_id',$this->catalog_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}