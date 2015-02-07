<?php
/* @var $this SituacionLaboralController */
/* @var $model SituacionLaboral */

$this->breadcrumbs=array(
	'Situacion Laborals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SituacionLaboral', 'url'=>array('index')),
	array('label'=>'Create SituacionLaboral', 'url'=>array('create')),
	array('label'=>'View SituacionLaboral', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SituacionLaboral', 'url'=>array('admin')),
);
?>

<h1>Update SituacionLaboral <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>