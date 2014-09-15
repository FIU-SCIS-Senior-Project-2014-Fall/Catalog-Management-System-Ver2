<?php

// uncomment the following to define a path alias
//Yii::setPathOfAlias('local','/var/curriculumdb/');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',//.DIRECTORY_SEPARATOR.'curriculumdb',
	'name'=>'My FIU Curriculum',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
//		'application.models.identifiers*',
//                'application.models.data*',
		'application.models.forms.*',
		'application.components.*',
		'application.components.concreteClasses.*',
                'application.modules.user.models.*',
                'application.modules.user.components.*',
                'application.modules.rights.*',
                'application.modules.rights.components.*'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'password',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
                //User
                'user'=>array(
                        'tableUsers' => 'acl_users',
                        'tableProfiles' => 'acl_profiles',
                        'tableProfileFields' => 'acl_profiles_fields',
                ),
                //rights module 
                'rights'=>array(
                        'install'=>false,
                ),
                'catalog',
                'xmlGenerator',

		
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class'=>'RWebUser',
                        // enable cookie-based authentication
                        'allowAutoLogin'=>true,
                        'loginUrl'=>array('/user/login'),                      
		),
                'authManager'=>array(
                    'class'=>'RDbAuthManager', // Provides support authorization item sorting.
                    'connectionID'=>'db', // use db connection to authenticate to database
                    'defaultRoles'=>array('Authenticated', 'Guest'),
                ),
                'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		//END uncomment the following to enable URLs in path-format
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			//'connectionString' => 'mysql:host=web-db.cs.fiu.edu;dbname=test',
			'connectionString' => 'mysql:host=localhost;dbname=curriculum',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'password',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'oscar.a.aparicio@gmail.com',
	),
    
        //Select base theme (on www folder)
        'theme'=>'scis',
    
);
