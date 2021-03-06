<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('layout' => TbHtml::FORM_LAYOUT_INLINE));?>
   
<div class="row">
   <legend class="span">Crear usuario</legend>
</div>

<div class="row">
   <div class="span8 offset1">
      <div class="well">
         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'username',
                  array('groupOptions'=>array('class'=>'span3'))); ?>
         </div>
         <div class="row">
            <?php echo $form->textFieldControlGroup( $model, 'nombre', array('groupOptions'=>array('class'=>'span3'))); ?>
            <?php echo $form->textFieldControlGroup( $model, 'apellido', array('groupOptions'=>array('class'=>'span3'))); ?>
            
         </div>
         <div class="row">
            <?php echo $form->passwordFieldControlGroup($model, 'create_password', 
                  array('groupOptions'=>array('class'=>'span3'))); ?>
            <?php echo $form->passwordFieldControlGroup($model, 'create_repassword', 
                  array('groupOptions'=>array('class'=>'span3'))); ?>
         </div>
         <div class="row">
            <?php echo $form->dropDownListControlGroup($model, 'role',
                  array('admin'=>'Administrador', 'writer'=>'Data Entry', 'reader' => 'Consulta'),
                  array('class'=>'span2', 'groupOptions'=>array('class'=>'span2'))); ?>   
            
         </div>
         <div class="row">
            <div class="span offset5">
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