<?php

/**
 * This is the model class for table "catalog".
 *
 * The followings are the available columns in table 'catalog':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $creationDate
 * @property integer $year
 * @property string $term
 * @property integer $activated
 * @property string $startingDate
 * @property integer $activation_userId
 * @property integer $parent_catalogId * 
 * @property integer $isProspective
 * @property integer $creatorId
 * @property integer $isProposed
 *
 * The followings are the available model relations:
 * @property CurrCourse[] $currCourses
 * @property CurrGroup[] $currGroups
 * @property CurrGroupSet[] $currGroupSets
 * @property CurrMajor[] $currMajors
 * @property CurrMajorType[] $currMajorTypes
 * @property CurrSet[] $currSets
 * @property CurrSetCourse[] $currSetCourses
 * @property CurrTrack[] $currTracks
 * @property CurrTrackGroup[] $currTrackGroups
 * @property HisCourse[] $hisCourses
 * @property HisCoursePrefix[] $hisCoursePrefixes
 * @property HisDgu[] $hisDgus
 * @property HisGroup[] $hisGroups
 * @property HisMajor[] $hisMajors
 * @property HisSet[] $hisSets
 * @property HisTrack[] $hisTracks
 */
class Catalog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Catalog the static model class
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
		return 'catalog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, creationDate, year, term', 'required'),
			array('year, activated, activation_userId, parent_catalogId, isProspective, isProposed, creatorId', 'numerical', 'integerOnly'=>true),
			array('name, description', 'length', 'max'=>255),
			array('term', 'length', 'max'=>6),
			array('startingDate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, creationDate, year, term, activated, startingDate, activation_userId, parent_catalogId, isProspective, creatorId, isProposed', 'safe', 'on'=>'search'),
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
			'currCourses' => array(self::HAS_MANY, 'CurrCourse', 'catalog_id'),
			'currGroups' => array(self::HAS_MANY, 'CurrGroup', 'catalog_id'),
			'currGroupSets' => array(self::HAS_MANY, 'CurrGroupSet', 'catalog_id'),
			'currMajors' => array(self::HAS_MANY, 'CurrMajor', 'catalog_id'),
			'currMajorTypes' => array(self::HAS_MANY, 'CurrMajorType', 'catalog_id'),
			'currSets' => array(self::HAS_MANY, 'CurrSet', 'catalog_id'),
			'currSetCourses' => array(self::HAS_MANY, 'CurrSetCourse', 'catalog_id'),
			'currTracks' => array(self::HAS_MANY, 'CurrTrack', 'catalog_id'),
			'currTrackGroups' => array(self::HAS_MANY, 'CurrTrackGroup', 'catalog_id'),
			'hisCourses' => array(self::HAS_MANY, 'HisCourse', 'catalog_id'),
			'hisCoursePrefixes' => array(self::HAS_MANY, 'HisCoursePrefix', 'catalog_id'),
			'hisDgus' => array(self::HAS_MANY, 'HisDgu', 'catalog_id'),
			'hisGroups' => array(self::HAS_MANY, 'HisGroup', 'catalog_id'),
			'hisMajors' => array(self::HAS_MANY, 'HisMajor', 'catalog_id'),
			'hisSets' => array(self::HAS_MANY, 'HisSet', 'catalog_id'),
			'hisTracks' => array(self::HAS_MANY, 'HisTrack', 'catalog_id'),
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
			'description' => 'Description',
			'creationDate' => 'Creation Date',
			'year' => 'Year',
			'term' => 'Term',
			'activated' => 'Activated',
			'startingDate' => 'Starting Date',
			'activation_userId' => 'Activation User',
			'parent_catalogId' => 'Parent Catalog',
            'isProspective' => 'Is Prospective ?',
            'creatorId' => 'Creator',
            'isProposed' => 'Is Proposed ?',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('creationDate',$this->creationDate,true);
		$criteria->compare('year',$this->year);
		$criteria->compare('term',$this->term,true);
		$criteria->compare('activated',$this->activated);
		$criteria->compare('startingDate',$this->startingDate,true);
		$criteria->compare('activation_userId',$this->activation_userId);
		$criteria->compare('parent_catalogId',$this->parent_catalogId);
        $criteria->compare('isProspective', $this->isProspective);
        $criteria->compare('creatorId', $this->creatorId);
        $criteria->compare('isProposed', $this->isProposed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}