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

   <?php echo $content; ?>

</div><!-- page -->

</body>
</html>
