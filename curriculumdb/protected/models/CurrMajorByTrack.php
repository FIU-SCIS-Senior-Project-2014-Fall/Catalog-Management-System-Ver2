<?php

/**
 * This is the model class for table "curr_major_track".
 *
 * The followings are the available columns in table 'curr_major_track':
 * @property integer $id
 * @property integer $major_id
 * @property integer $track_id
 * @property integer $catalog_id
 *
 * The followings are the available model relations:
 * @property CurrTrack $track
 * @property CurrMajor $major
 */
class CurrMajorByTrack extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CurrMajorByTrack the static model class
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
		return 'curr_major_track';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('major_id, track_id, catalog_id', 'required'),
			array('major_id, track_id, catalog_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, major_id, track_id, catalog_id', 'safe', 'on'=>'search'),
//			array('major_id, track_id, catalog_id', 'on'=>'insert', 'message'=>'This link already exist'),
                    
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
			'track' => array(self::BELONGS_TO, 'CurrTrack', 'track_id'),
			'major' => array(self::BELONGS_TO, 'CurrMajor', 'major_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'major_id' => 'Major',
			'track_id' => 'Track',
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
		$criteria->compare('major_id',$this->major_id);
		$criteria->compare('track_id',$this->track_id);
		$criteria->compare('catalog_id',$this->catalog_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}