<?php echo TbHtml::beginFormTb(TbHtml::FORM_LAYOUT_HORIZONTAL); ?>

<div class="row">
   <legend class="span10">
      Evento en la solicitud a la fecha.
   </legend>
</div>
<div class="row">
   <div class="span8">
      <div class="row">
         <div class="span7 offset1">
            <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING,
            "Utilize texto SIN FORMATO, es decir, de una explicacion coloquial de lo sucedido. Se guardara con fecha de hoy."); ?>
         </div>
      </div>
      <div class="row">
         <div class="span7 offset1">
            <?php echo TbHtml::textArea('detalle', '',
                           array('rows'=>15, 'style'=>'width:80%;')); ?>
         </div>
      </div>

      <div class="row">&nbsp;</div>
      <div class="row">
         <div class="span offset3">
            <?php echo TbHtml::link('Cancelar', Yii::app()->createUrl("solicitud/admin"),
                  array('class'=>'btn btn-' .TbHtml::BUTTON_COLOR_DEFAULT));?>
         </div>
         <div class="span">
            <?php echo TbHtml::submitButton('Crear', array('color' =>TbHtml::BUTTON_COLOR_SUCCESS));?>
         </div>
      </div>

   </div>
</div>

<?php echo TbHtml::endForm(); ?>