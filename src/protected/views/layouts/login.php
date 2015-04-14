<?php Yii::app()->bootstrap->register(); ?>

<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta name="language" content="en">
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css">

   <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container">
   <div class="row">
      <div id="logo" class="span10 offset3"><?php echo CHtml::image('/images/logo_header.png');?></div>
   </div>
   <?php echo $content; ?>

</div><!-- page -->

</body>
</html>
