<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class EditorSelectionForm extends CFormModel
{
        public $dgu;
	public $major;      
	public $track;
	public $catalog;

        public function MajorSelectionForm(){
            
        }
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// reqired fields
			array('major, track, catalog', 'required'),
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
                        'dgu'=>'Degree Granted Unit',
			'major'=>'Major',
			'track'=>'Track',
			'catalog'=>'Catalog',
		);
	}
}
