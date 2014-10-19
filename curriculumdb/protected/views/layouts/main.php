<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/page.css" />


    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/prospective.css" media="screen, projection" />

    <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/doc/api/js/prospective.js" ></script>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/FIU_SCIS_Logo.png">
		</div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(

				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'yii-info')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Majors', 'url'=>array('/manage')),				
        		array('url'=>array('/user/admin'), 'label'=>'User', 			
        			'visible'=>Yii::app()->getModule('user')->isAdmin()),				
        		array('url'=>array('/xmlGenerator'), 'label'=>'Xml', 			
        			'visible'=>Yii::app()->getModule('user')->isAdmin()),			
        		array('url'=>array('/catalog/manage'), 'label'=>'Catalog', 			
        			'visible'=>Yii::app()->getModule('user')->isAdmin()),
                //Jose...provide the capability of accessing prospective catalogs if the user is not a guest
                array('label'=>'Prospective','url'=>array('/catalog/prospective'), 
                    'visible'=>Yii::app()->user->isGuest == false),
				/* array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest), */
				/* array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest), */


//--USER AND RIGHTS ADD-ONS
        //array('label'=>'Rights', 'url'=>array('/rights'), 'visible'=>!Yii::app()->user->isGuest),
        array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login"), 'visible'=>Yii::app()->user->isGuest),
        array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Profile"), 'visible'=>!Yii::app()->user->isGuest),
        array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
//--USER AND RIGHTS ADD-ONS END

			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; by Tim Downey as Project Mentor.<br/>
                         by Oscar&Tiffany Project Development in v1.0.<br/>
                         by Jose&Christopher Project Development in v2.0.<br/>
		All Rights Reserved.<br/>
		<?php echo 'FIU - School of Computer Science!';?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
