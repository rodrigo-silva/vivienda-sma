<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('layout' => TbHtml::FORM_LAYOUT_INLINE));?>
   
<div class="row">
   <legend class="span">Actualizar usuario</legend>
</div>
<div class="row">
   <div class="span6 offset2">
      <div class="well">
         <div class="row">
            <?php echo $form->textFieldControlGroup( $model, 'nombre', array('groupOptions'=>array('class'=>'offset1 span3'))); ?>
         </div>
         <div class="row">
            <?php echo $form->textFieldControlGroup( $model, 'apellido', array('groupOptions'=>array('class'=>'offset1 span3'))); ?>
         </div>
         <div class="row">
            <?php if( Yii::app()->user->checkAccess('admin') ): ?>
               <?php echo $form->dropDownListControlGroup($model, 'role',
                     array('admin'=>'Administrador', 'writer'=>'Data Entry', 'reader' => 'Consulta'),
                     array('groupOptions'=>array('class'=>'offset1 span2'))); ?>   
            <?php endif?>
         </div>
         <div class="row">&nbsp;</div>
         <div class="row">
            <div class="span offset3">
               <?php echo TbHtml::link('Cancelar', Yii::app()->createUrl("user/admin"),
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