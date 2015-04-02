<?php
   $form = $this->beginWidget('bootstrap.widgets.TbActiveForm');
   
   echo '<fieldset>';
   echo '<legend>Datos solicitud</legend>';
   echo $form->hiddenField($model, 'es_alquiler', array('id'=>'es-alquiler'));
   echo $form->dropDownListControlGroup($model, 'tipo_solicitud_id', $model->getTipoSolicitudes(), array('id'=>'tipo-solicitud-combo'));
   echo $form->dropDownListControlGroup($model, 'condicion_lote_id', $model->getCondicionesLote(), 
      array('groupOptions'=>array('id'=>'condicion-lote-combo')));
   echo $form->dropDownListControlGroup($model, 'tipo_vivienda_id', $model->getTiposVivienda());
   echo $form->dropDownListControlGroup($model, 'condicion_uso_id', $model->getCondicionesDeUso(), array('id'=>'condicion-uso-combo'));
   echo '<div id="alquiler-container">';
      echo $form->inlineRadioButtonListControlGroup($model, 'formal', array("Formal", 'Informal'));
      echo $form->inlineRadioButtonListControlGroup($model, 'costo_superior', array('Si', 'No'));
   echo '</div>';
   echo '</fieldset>';

   echo '<fieldset>';
   echo '<legend>Datos del domicilio</legend>';
   echo $form->textFieldControlGroup($model, 'calle');
   echo $form->textFieldControlGroup($model, 'altura');
   echo $form->textFieldControlGroup($model, 'piso');
   echo $form->textFieldControlGroup($model, 'departamento');
   echo $form->textFieldControlGroup($model, 'casa');
   echo $form->textFieldControlGroup($model, 'lote');
   echo $form->textAreaControlGroup($model, 'observaciones');
   echo '</fieldset>';
   
   echo TbHtml::submitButton('Continuar');

   $this->endWidget();
?>


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
         jQuery('#es-alquiler').val(true);
      } else {
         jQuery('#alquiler-container').hide()
         jQuery('#es-alquiler').val(false);
      }
   });

   jQuery('#tipo-solicitud-combo').trigger('change')
   jQuery('#condicion-uso-combo').trigger('change')
</script>