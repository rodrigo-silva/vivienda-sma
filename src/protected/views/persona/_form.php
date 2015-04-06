<?php
   $provincias = array('Buenos Aires' => 'Buenos Aires','Capital Federal' => 'Capital Federal','Catamarca' => 'Catamarca','Chaco' => 'Chaco','Chubut' => 'Chubut','Cordoba' => 'Cordoba','Corrientes' => 'Corrientes','Entre Rios' => 'Entre Rios','Formosa' => 'Formosa','Jujuy' => 'Jujuy','La Pampa' => 'La Pampa','La Rioja' => 'La Rioja','Mendoza' => 'Mendoza','Misiones' => 'Misiones','Neuquen' => 'Neuquen','Ri Negro' => 'Ri Negro','Salta' => 'Salta','San Juan' => 'San Juan','San Luis' => 'San Luis','Santa Cruz' => 'Santa Cruz','Santa Fe' => 'Santa Fe','Santiago del Estero' => 'Santiago del Estero','Tierra del Fuego' => 'Tierra del Fuego','Tucuman' => 'Tucuman');
   
   $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('layout' => TbHtml::FORM_LAYOUT_HORIZONTAL));
   echo '<fieldset>';
   echo '<legend>Datos Personales</legend>';
   echo $form->textFieldControlGroup($model, 'nombre');
   echo $form->textFieldControlGroup($model, 'apellido');
   echo $form->textFieldControlGroup($model, 'dni');
   echo $form->dropDownListControlGroup($model, 'sexo', array('M'=>'Masculino', 'F'=>'Femenino'));
   
   echo $form->textFieldControlGroup($model, 'fecha_nac', array('readonly'=>''));
   echo $form->dropDownListControlGroup($model, 'nacionalidad', array('Argentino/a'=>'Argentino/a', 'Extranjero/a'=>'Extranjero/a'),  array('id'=>'nacionalidad-combo'));
   echo $form->textFieldControlGroup($model, 'pais_nac', array('groupOptions'=>array('id'=>'input-pais-nac')));
   echo $form->dropDownListControlGroup($model, 'provincia_nac',$provincias, array('groupOptions'=>array('id'=>'input-provincias-nac')));
   echo $form->textFieldControlGroup($model, 'localidad_nac', array('groupOptions'=>array('id'=>'input-localidad-nac')));

   echo $form->textFieldControlGroup($model, 'telefono', array('prepend' => '02972', 'span'=>2));
   echo $form->textFieldControlGroup($model, 'celular_prefijo');
   echo $form->textFieldControlGroup($model, 'celular', array('prepend' => '15', 'span'=>2));
   echo $form->inlineCheckBoxListControlGroup($model, 'condicionesEspeciales', $model->getCondicionesEspeciales());
   echo '</fieldset>';
   
   echo '<fieldset>';
   echo '<legend>Situacion Economica</legend>';
   echo $form->textFieldControlGroup($model, 'ingresos_alimentos', array('prepend' => '$', 'append' => '.00', 'span' => 1, 'style'=>"text-align:end"));
   echo $form->textFieldControlGroup($model, 'ingresos_subsidio', array('prepend' => '$', 'append' => '.00', 'span' => 1, 'style'=>"text-align:end"));
   echo $form->dropDownListControlGroup($model, 'tipo_situacion_laboral_id', $model->getSituacionesLaborales(), array('id'=>"situacion-laboral-combo"));
   
   echo '<div id="detalle-ocupacion-container">'; 
      echo $form->inlineRadioButtonListControlGroup($model, 'relacion_dependencia', array('Cuenta propista', 'Relacion de Dependencia'));
      echo $form->inlineRadioButtonListControlGroup($model, 'formal', array('No', 'Si'));
      echo $form->textFieldControlGroup($model, 'ingresos_laborales', array('prepend' => '$', 'append' => '.00', 'span' => 1, 'style'=>"text-align:end"));
      echo $form->textFieldControlGroup($model, 'ocupacion');
   echo '</div>'; 
   echo '</fieldset>';


   echo TbHtml::submitButton('Guardar');
   $this->endWidget();

?>
<script type="text/javascript">
   //Calendario
   jQuery('#PersonaForm_fecha_nac').datepicker({dateFormat: "yy-mm-dd", changeYear:true, yearRange:"c-100:+0",
                                                 defaultDate: "-30y"}).datepicker('widget').css('font-size', '13px');
   jQuery('#PersonaForm_fecha_nac').attr("readonly", "true");

   // Nacionalidad
   jQuery('#nacionalidad-combo').change(function(){
      if($(this).find('option:selected').text().toUpperCase() == 'ARGENTINO/A') {
         jQuery('#input-pais-nac').hide();
         jQuery('#input-pais-nac input').val("Argentina")
         jQuery('#input-provincias-nac').show()
         jQuery('#input-localidad-nac').show()
         if(! jQuery("#PersonaForm_provincia_nac").val()) {
            jQuery("#PersonaForm_provincia_nac").val("Buenos Aires")
         }
      } else {
         if (jQuery('#input-pais-nac input').val() == "Argentina"){
            jQuery('#input-pais-nac input').val("")
         }
         jQuery('#input-pais-nac').show();
         jQuery('#input-provincias-nac').hide()
         jQuery('#input-localidad-nac').hide()
         jQuery('#PersonaForm_provincia_nac').val("")
      }

   });

   //situacion laboral
   jQuery('#situacion-laboral-combo').change(function(){
      if($(this).find('option:selected').text().toUpperCase() == 'OCUPADO') {
         jQuery('#detalle-ocupacion-container').show()
      } else {
         jQuery('#detalle-ocupacion-container').hide()
      }
   });

   jQuery('#situacion-laboral-combo').trigger('change')
   jQuery('#nacionalidad-combo').trigger('change')
</script>