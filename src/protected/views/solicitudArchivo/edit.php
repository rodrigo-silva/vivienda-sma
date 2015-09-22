<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('layout' => TbHtml::FORM_LAYOUT_HORIZONTAL)); ?>

<div class="row">
   <legend class="span10">
      Archivar Solicitud
   </legend>
</div>
<div class="row">
   <div class="span8">
      
      <div class="row">
         <?php echo $form->hiddenField($model, 'numero'); ?>
         <?php echo $form->dropDownListControlGroup($model, 'tipo_resolucion_id', $model->getTiposResolucion(),
               array('groupOptions'=>array('class'=>'span3'))); ?>
      </div>

      <div class="row">
         <?php echo $form->textAreaControlGroup($model, 'comentarios',
               array('rows'=>15, 'style'=>'width:80%;', 'groupOptions'=>array('class'=>'span8'))); ?>
      </div>

      <div class="row">
         <div class="span offset5">
            <?php echo TbHtml::link('Cancelar', Yii::app()->createUrl("solicitudArchivo"),
                  array('class'=>'btn btn-' .TbHtml::BUTTON_COLOR_DEFAULT));?>
         </div>
         <div class="span">
            <?php echo TbHtml::submitButton('Archivar', array('color' =>TbHtml::BUTTON_COLOR_WARNING));?>
         </div>
      </div>

   </div>
</div>

<?php $this->endWidget();?>