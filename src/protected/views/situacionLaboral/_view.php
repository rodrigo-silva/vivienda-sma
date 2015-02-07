<?php
/* @var $this SituacionLaboralController */
/* @var $data SituacionLaboral */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trabaja')); ?>:</b>
	<?php echo CHtml::encode($data->trabaja); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jubilado_pensionado')); ?>:</b>
	<?php echo CHtml::encode($data->jubilado_pensionado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('formal')); ?>:</b>
	<?php echo CHtml::encode($data->formal); ?>
	<br />


</div>