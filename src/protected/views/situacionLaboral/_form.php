<?php
/* @var $this SituacionLaboralController */
/* @var $model SituacionLaboral */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'situacion-laboral-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'trabaja'); ?>
		<?php echo $form->textField($model,'trabaja'); ?>
		<?php echo $form->error($model,'trabaja'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jubilado_pensionado'); ?>
		<?php echo $form->textField($model,'jubilado_pensionado'); ?>
		<?php echo $form->error($model,'jubilado_pensionado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formal'); ?>
		<?php echo $form->textField($model,'formal'); ?>
		<?php echo $form->error($model,'formal'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->