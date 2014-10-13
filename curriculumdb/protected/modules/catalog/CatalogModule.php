<?php

class CatalogModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'catalog.models.*',
			'catalog.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
        
        public function isCatalogActivated($catalogId){
            $catalog = Catalog::model()->findByPk($catalogId);
            
            if($catalog->activated == 1)
                return true;
            else
                return false;
        }
        
        
        /**
	 * @param $str
	 * @param $params
	 * @param $dic
	 * @return string
	 */
	public static function t($str='',$params=array(),$dic='user') {
		return Yii::t("CatalogModule.".$dic, $str, $params);
	}
    
    public static function test()
    {
        return true;
    }
}
