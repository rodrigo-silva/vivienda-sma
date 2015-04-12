<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('layout' => TbHtml::FORM_LAYOUT_INLINE, 'htmlOptions'=>array('autocomplete' => 'off')));?>
   
   <div class="row">
      <legend class="span">Cambiar password</legend>
   </div>
   <div class="well">
      
      <div class="row">
         <?php echo $form->passwordFieldControlGroup($model, 'reset_password', array('class'=>'span2','groupOptions'=>array('class'=>'span2'))); ?>
         <?php echo $form->passwordFieldControlGroup($model, 'reset_repassword', array('class'=>'span2','groupOptions'=>array('class'=>'span2'))); ?>
      </div>

   <div class="row">
      <div class="span offset6">
         <?php echo TbHtml::link('Cancelar', Yii::app()->createUrl("user/admin"),
         array('class'=>'btn btn-' .TbHtml::BUTTON_COLOR_DEFAULT));?>
      </div>
      <div class="span">
         <?php echo TbHtml::submitButton('Guardar', array('color'=>TbHtml::BUTTON_COLOR_SUCCESS)); ?>
      </div>
      
   </div>

<?php $this->endWidget();?>