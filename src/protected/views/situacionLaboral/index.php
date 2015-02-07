<?php
/* @var $this SituacionLaboralController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Situacion Laborals',
);

$this->menu=array(
	array('label'=>'Create SituacionLaboral', 'url'=>array('create')),
	array('label'=>'Manage SituacionLaboral', 'url'=>array('admin')),
);
?>

<h1>Situacion Laborals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
