<?php Yii::app()->bootstrap->register(); ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css'); ?>


<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<!--link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print"-->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"> -->
   <!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"> -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div class="row">
		<div id="logo" class="span10"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->
   
   <div class="row">
      <div class="span6">
      <?php
        
       $this->widget('bootstrap.widgets.TbNav', array(
            'type' => TbHtml::NAV_TYPE_TABS,
            'items' =>
                  array(
                     array('label' => 'Personas', 'url' => '#', 'active'=> Yii::app()->controller->id == 'persona', 'items'=>array(
                        array('label'=>'Alta Persona', 'url'=>Yii::app()->createUrl('persona/create'),
                           'visible'=>Yii::app()->user->checkAccess('writer')),
                        array('label'=>'Listado', 'url'=>Yii::app()->createUrl('persona')),
                     )),
                     array('label' => 'Solicitudes', 'url' => '#','active'=> Yii::app()->controller->id == 'solicitud', 'items'=>array(
                        array('label'=>'Nueva solicitud', 'url'=>Yii::app()->createUrl('solicitud/new'),
                           'visible'=>Yii::app()->user->checkAccess('writer')),
                        array('label'=>'Listado', 'url'=>Yii::app()->createUrl('solicitud')),
                     )),
                     array('label' => 'Usuarios', 'url' => '#','active'=> Yii::app()->controller->id == 'user', 'items'=>array(
                        array('label'=>'Alta usuario', 'url'=>Yii::app()->createUrl('user/create')),
                        array('label'=>'Listado', 'url'=>Yii::app()->createUrl('user')),
                     ), 'visible'=>Yii::app()->user->checkAccess('admin')),
                  ),
         )); 
      ?>
         
      </div>
  
      <div class="span5">
      <?php
        
       $this->widget('bootstrap.widgets.TbNav', array(
            'type' => TbHtml::NAV_TYPE_TABS,
            'items' =>
                  array(
                     array('label' => 'Personas', 'url' => '#', 'active'=> Yii::app()->controller->id == 'persona', 'items'=>array(
                        array('label'=>'Alta Persona', 'url'=>Yii::app()->createUrl('persona/create'),
                           'visible'=>Yii::app()->user->checkAccess('writer')),
                        array('label'=>'Listado', 'url'=>Yii::app()->createUrl('persona')),
                     )),
                     array('label' => 'Solicitudes', 'url' => '#','active'=> Yii::app()->controller->id == 'solicitud', 'items'=>array(
                        array('label'=>'Nueva solicitud', 'url'=>Yii::app()->createUrl('solicitud/new'),
                           'visible'=>Yii::app()->user->checkAccess('writer')),
                        array('label'=>'Listado', 'url'=>Yii::app()->createUrl('solicitud')),
                     )),
                     array('label' => 'Usuarios', 'url' => '#','active'=> Yii::app()->controller->id == 'user', 'items'=>array(
                        array('label'=>'Alta usuario', 'url'=>Yii::app()->createUrl('user/create')),
                        array('label'=>'Listado', 'url'=>Yii::app()->createUrl('user')),
                     ), 'visible'=>Yii::app()->user->checkAccess('admin')),
                  ),
         )); 
      ?>
         
      </div>
   </div>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer" class="row">
      <div class="span10">
      </div>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
