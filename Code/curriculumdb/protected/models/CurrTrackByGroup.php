<?php

/**
 * This is the model class for table "curr_track_group".
 *
 * The followings are the available columns in table 'curr_track_group':
 * @property integer $id
 * @property integer $track_id
 * @property integer $group_id
 * @property integer $required
 * @property integer $catalog_id
 *
 * The followings are the available model relations:
 * @property Catalog $catalog
 * @property CurrTrack $track
 * @property CurrGroup $group
 */
class CurrTrackByGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CurrTrackByGroup the static model class
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
		return 'curr_track_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('track_id, group_id, catalog_id', 'required'),
			array('track_id, group_id, required, catalog_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, track_id, group_id, required, catalog_id', 'safe', 'on'=>'search'),
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
			'track' => array(self::BELONGS_TO, 'CurrTrack', 'track_id'),
			'group' => array(self::BELONGS_TO, 'CurrGroup', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'track_id' => 'Track',
			'group_id' => 'Group',
			'required' => 'Required',
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
		$criteria->compare('track_id',$this->track_id);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('required',$this->required);
		$criteria->compare('catalog_id',$this->catalog_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}