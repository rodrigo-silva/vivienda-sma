<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm');?>
<?php echo $form->hiddenField($model, 'es_alquiler', array('id'=>'es-alquiler')); ?>

<div class="row">
   <legend class="span10">
      <div class="row">
         <div class="span8">Datos Basicos de la Solicitud</div>
         <div class="span1">
            <?php echo TbHtml::labelTb("$titular->nombre $titular->apellido", array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
         </div>
      </div>
   </legend>
</div>

<div class="row">
</div>

<div class="row">
   <div class="span8 offset1">
      <div class="well">
         <div class="row">
            <?php echo $form->dropDownListControlGroup($model, 'tipo_solicitud_id',
                  $model->getTipoSolicitudes($titular), array('id'=>'tipo-solicitud-combo', 'groupOptions'=>array('class'=>'span3')));?>
            <?php echo $form->dropDownListControlGroup($model, 'condicion_lote_id', $model->getCondicionesLote(), 
               array('groupOptions'=>array('id'=>'condicion-lote-combo', 'class'=>'span3')));?>
         </div>

         <div class="row">
            <?php echo $form->dropDownListControlGroup( $model, 'tipo_vivienda_id', $model->getTiposVivienda(),
                  array('groupOptions'=>array('class'=>'span3')) ); ?>
            <?php echo $form->dropDownListControlGroup($model, 'condicion_uso_id', $model->getCondicionesDeUso(),
                  array('id'=>'condicion-uso-combo', 'groupOptions'=>array('class'=>'span3')) ); ?>
         </div>

         <div class="row">
            <div id="alquiler-container">
               <?php echo $form->inlineRadioButtonListControlGroup( $model, 'formal', array('Informal', 'Formal'),
                     array('groupOptions'=>array('class'=>'span3'))); ?>
               <?php echo $form->inlineRadioButtonListControlGroup( $model, 'costo_superior', array('No', 'Si'),
                     array('groupOptions'=>array('class'=>'span3')) ); ?>
            </div>
         </div>

         <div class="row">
            <?php echo $form->checkBoxControlGroup($model, 'comparte_dormitorio',
                  array('groupOptions'=>array('class'=>'span3')));?>
         </div>

      </div>
   </div>
</div>

<div class="row">
   <legend class="span10">Datos del domicilio de la solicitud</legend>
</div>

<div class="row">
   <div class="span8 offset1">
      <div class="well">
         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'calle', array('groupOptions'=>array('class'=>'span3')) );?>
            <?php echo $form->textFieldControlGroup($model, 'altura', array('groupOptions'=>array('class'=>'span3')) );?>
            
         </div>

         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'cruce_calle_1', array('groupOptions'=>array('class'=>'span3')) );?>
            <?php echo $form->textFieldControlGroup($model, 'cruce_calle_2', array('groupOptions'=>array('class'=>'span3')) );?>
         </div>

         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'piso', array('groupOptions'=>array('class'=>'span3')) );?>
            <?php echo $form->textFieldControlGroup($model, 'departamento', array('groupOptions'=>array('class'=>'span3')) );?>
         </div>

         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'casa', array('groupOptions'=>array('class'=>'span3')) );?>
            <?php echo $form->textFieldControlGroup($model, 'puerta', array('groupOptions'=>array('class'=>'span3')) );?>
         </div>

         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'manzana', array('groupOptions'=>array('class'=>'span3')) );?>
            <?php echo $form->textFieldControlGroup($model, 'lote', array('groupOptions'=>array('class'=>'span3')) );?>
         </div>

         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'edificio', array('groupOptions'=>array('class'=>'span3')) );?>
            <?php echo $form->textFieldControlGroup($model, 'barrio', array('groupOptions'=>array('class'=>'span3')) );?>
         </div>

         <div class="row">
            <?php echo $form->textAreaControlGroup($model, 'observaciones', array('groupOptions'=>array('class'=>'span3')) );?>
         </div>

         <div class="row">&nbsp;</div>
         <div class="row">
            <div class="span offset4">
               <?php echo TbHtml::link('Cancelar', Yii::app()->createUrl("solicitud/admin"),
               array('class'=>'btn'));?>
            </div>
            <div class="span">
               <?php echo TbHtml::submitButton('Guardar', array('color'=>TbHtml::BUTTON_COLOR_SUCCESS)); ?>
            </div>
         </div>

      </div>
   </div>
</div>
<?php $this->endWidget(); ?>




<script type="text/javascript">
   //situacion laboral
   jQuery('#tipo-solicitud-combo').change(function() {
      if($(this).find('option:selected').text().indexOf('Lote') > -1) {
         jQuery('#condicion-lote-combo').hide()
      } else {
         jQuery('#condicion-lote-combo').show()
      }
   });

   jQuery('#condicion-uso-combo').change(function() {
      if($(this).find('option:selected').text().indexOf('Alqui') > -1) {
         jQuery('#alquiler-container').show()
         jQuery('#es-alquiler').val(1);
      } else {
         jQuery('#alquiler-container').hide()
         jQuery('#es-alquiler').val(0);
      }
   });

   jQuery('#tipo-solicitud-combo').trigger('change')
   jQuery('#condicion-uso-combo').trigger('change')
</script>