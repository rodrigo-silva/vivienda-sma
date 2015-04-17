<div id="hero-container" class=<?php echo empty($model->errors)?'""':'"hide"'?> >
   <?php
   echo TbHtml::heroUnit('Atencion!',<<<EOD
   Usted esta a punto de archivar la solicitud numero <strong>#$model->numero</strong>.
   Este proceso es <strong>irreversible</strong>. Si bien la informacion sera respladada para futuras consultas,
   no podra ser ni modificada ni sujeto de adjudicacion.
EOD
    ,array()); ?>
   <?php echo TbHtml::link('Cancelar', Yii::app()->createUrl("solicitud/admin"),
         array('class'=>'btn btn-' . TbHtml::BUTTON_SIZE_LARGE . ' btn-' .TbHtml::BUTTON_COLOR_DEFAULT));?>
   <?php echo TbHtml::button("Archivar", array('color' =>TbHtml::BUTTON_COLOR_WARNING,
                                               'size' => TbHtml::BUTTON_SIZE_LARGE, 'id'=>'archivar-btn'));?>
</div>

<?php
   $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('layout' => TbHtml::FORM_LAYOUT_HORIZONTAL, 
                                                                      'htmlOptions'=>array('class'=>empty($model->errors)?'hide':'')));
   echo '<fieldset>';
   echo '<legend>Archivar solicitud</legend>';
   echo $form->hiddenField($model, 'numero');
   echo $form->dropDownListControlGroup($model, 'tipo_resolucion_id', $model->getTiposResolucion());
   echo $form->textAreaControlGroup($model, 'comentarios');
   echo '</fieldset>';
   echo TbHtml::link('Cancelar', Yii::app()->createUrl("solicitud/admin"),
         array('class'=>'btn btn-' .TbHtml::BUTTON_COLOR_DEFAULT));
   echo TbHtml::submitButton('Archivar', array('color' =>TbHtml::BUTTON_COLOR_WARNING));
   $this->endWidget();
?>

<script type="text/javascript">
   jQuery("#archivar-btn").click(function(){jQuery("#hero-container").hide();jQuery("form").show()})
</script>