<div id="hero-container" class=<?php echo empty($model->errors)?'""':'"hide"'?> >
   <?php
   echo TbHtml::heroUnit('Atencion!',<<<EOD
   Usted esta a punto de archivar la solicitud numero <strong>#$model->numero</strong>.
   Este proceso es <strong>irreversible</strong>. Si bien la informacion sera respladada para futuras consultas,
   no podra ser ni modificada ni sujeto de adjudicacion.
EOD
    ,array()); ?>

<div class="row">
   <div class="span2 offset6">
      <?php echo TbHtml::link('Cancelar', Yii::app()->createUrl("solicitud/admin"),
            array('class'=>'btn btn-' . TbHtml::BUTTON_SIZE_LARGE . ' btn-' .TbHtml::BUTTON_COLOR_DEFAULT));?>
   </div>
   <div class="span2">
      <?php echo TbHtml::button("Archivar", array('color' =>TbHtml::BUTTON_COLOR_WARNING,
                                                  'size' => TbHtml::BUTTON_SIZE_LARGE, 'id'=>'archivar-btn'));?>
   </div>
</div>
</div>

<?php
   $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('layout' => TbHtml::FORM_LAYOUT_HORIZONTAL, 
                  'htmlOptions'=>array('class'=>empty($model->errors)?'hide':'')));?>

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
            <?php echo TbHtml::link('Cancelar', Yii::app()->createUrl("solicitud/admin"),
                  array('class'=>'btn btn-' .TbHtml::BUTTON_COLOR_DEFAULT));?>
         </div>
         <div class="span">
            <?php echo TbHtml::submitButton('Archivar', array('color' =>TbHtml::BUTTON_COLOR_WARNING));?>
         </div>
      </div>

   </div>
</div>

<?php $this->endWidget();?>

<script type="text/javascript">
   jQuery("#archivar-btn").click(function(){jQuery("#hero-container").hide();jQuery("form").show()})
</script>