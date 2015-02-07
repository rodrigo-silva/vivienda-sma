<?php
/* @var $this SituacionLaboralController */
/* @var $model SituacionLaboral */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trabaja'); ?>
		<?php echo $form->textField($model,'trabaja'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jubilado_pensionado'); ?>
		<?php echo $form->textField($model,'jubilado_pensionado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'formal'); ?>
		<?php echo $form->textField($model,'formal'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->