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

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

<?php
   $this->widget('bootstrap.widgets.TbNavbar', array(
      'brandLabel' => '',
      'display' => '',
      'items' => array(
         array(
            'class' => 'bootstrap.widgets.TbNav',
            'items' => array(
               array('label' => 'Personas', 'url' => '#', 'active'=> Yii::app()->controller->id == 'persona', 'items'=>array(
                  array('label'=>'Alta Persona', 'url'=>Yii::app()->createUrl('persona/create')),
                  array('label'=>'Listado', 'url'=>Yii::app()->createUrl('persona')),
               )),
               array('label' => 'Solicitudes', 'url' => '#','active'=> Yii::app()->controller->id == 'solicitud', 'items'=>array(
                  array('label'=>'Nueva solicitud', 'url'=>Yii::app()->createUrl('solicitud/new')),
                  array('label'=>'Listado', 'url'=>Yii::app()->createUrl('solicitud')),
               )),
            ),
         )
      ),
   )); 
?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer" class="row">
      <div class="span10">
      </div>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
