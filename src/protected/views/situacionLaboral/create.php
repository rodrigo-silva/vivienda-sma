<?php
/* @var $this SituacionLaboralController */
/* @var $model SituacionLaboral */

$this->breadcrumbs=array(
	'Situacion Laborals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SituacionLaboral', 'url'=>array('index')),
	array('label'=>'Manage SituacionLaboral', 'url'=>array('admin')),
);
?>

<h1>Create SituacionLaboral</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>