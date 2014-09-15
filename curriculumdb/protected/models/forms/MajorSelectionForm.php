<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class MajorSelectionForm extends CFormModel
{
        public $majorName;
	public $major;
	public $track;
	public $term;

        public function MajorSelectionForm(){
            
        }
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// reqired fields
			array('majorName, major, track, term', 'required'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'major'=>'Major',
			'track'=>'Track',
			'term'=>'Term you where accepted into the University',
		);
	}
}
