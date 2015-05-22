<?php Yii::app()->bootstrap->register(); ?>
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
   <div id="logo" class="span9 offset2"><?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/logo_header_top.png');?></div>
</div>
<div id="content" class="row">
   <div class="span10 offset1">
      <?php echo $content; ?>
   </div>
</div>

</div><!-- page -->

</body>
</html>
