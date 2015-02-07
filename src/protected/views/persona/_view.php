<?php
/* @var $this PersonaController */
/* @var $data Persona */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apellido')); ?>:</b>
	<?php echo CHtml::encode($data->apellido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dni')); ?>:</b>
	<?php echo CHtml::encode($data->dni); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sexo')); ?>:</b>
	<?php echo CHtml::encode($data->sexo); ?>
	<br />

</div>