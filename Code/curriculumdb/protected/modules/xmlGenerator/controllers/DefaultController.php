<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
            error_reporting(E_ALL);
ini_set('display_errors', '1');

            $xmlGen = new XmlGenerator(0);
            $xml = $xmlGen->generateXml(XmlGenerator::ENTITY_MAJOR, 2);
            echo $xml;echo ':)';
//		$this->render('index');
	}
}