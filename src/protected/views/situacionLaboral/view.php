<?php
/* @var $this SituacionLaboralController */
/* @var $model SituacionLaboral */

$this->breadcrumbs=array(
	'Situacion Laborals'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SituacionLaboral', 'url'=>array('index')),
	array('label'=>'Create SituacionLaboral', 'url'=>array('create')),
	array('label'=>'Update SituacionLaboral', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SituacionLaboral', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SituacionLaboral', 'url'=>array('admin')),
);
?>

<h1>View SituacionLaboral #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'trabaja',
		'jubilado_pensionado',
		'formal',
	),
)); ?>
