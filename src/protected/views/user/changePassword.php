<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('layout' => TbHtml::FORM_LAYOUT_INLINE, 'htmlOptions'=>array('autocomplete' => 'off')));?>
   
<div class="row">
   <legend class="span">Cambiar password</legend>
</div>
<div class="row">
   <div class="span8 offset1">
      <div class="well">
         <div class="row">
            <?php echo $form->passwordFieldControlGroup($model, 'change_oldPassword', 
                  array('groupOptions'=>array('class'=>'span3'))); ?>
         </div>
         <div class="row">
            <?php echo $form->passwordFieldControlGroup($model, 'change_password',
                  array('groupOptions'=>array('class'=>'span3'))); ?>
            <?php echo $form->passwordFieldControlGroup($model, 'change_repassword',
                  array('groupOptions'=>array('class'=>'span3'))); ?>
         </div>
         <div class="row">&nbsp;</div>
         <div class="row">
            <div class="span offset5">
               <?php echo TbHtml::link('Cancelar', Yii::app()->homeUrl,
               array('class'=>'btn btn-' .TbHtml::BUTTON_COLOR_DEFAULT));?>
            </div>
            <div class="span">
               <?php echo TbHtml::submitButton('Guardar', array('color'=>TbHtml::BUTTON_COLOR_SUCCESS)); ?>
            </div>
         </div>
      </div>
   </div>
</div>

<?php $this->endWidget();?>