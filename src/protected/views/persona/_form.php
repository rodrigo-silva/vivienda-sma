<?php $provincias = array('Buenos Aires' => 'Buenos Aires','Capital Federal' => 'Capital Federal','Catamarca' => 'Catamarca','Chaco' => 'Chaco','Chubut' => 'Chubut','Cordoba' => 'Cordoba','Corrientes' => 'Corrientes','Entre Rios' => 'Entre Rios','Formosa' => 'Formosa','Jujuy' => 'Jujuy','La Pampa' => 'La Pampa','La Rioja' => 'La Rioja','Mendoza' => 'Mendoza','Misiones' => 'Misiones','Neuquen' => 'Neuquen','Ri Negro' => 'Ri Negro','Salta' => 'Salta','San Juan' => 'San Juan','San Luis' => 'San Luis','Santa Cruz' => 'Santa Cruz','Santa Fe' => 'Santa Fe','Santiago del Estero' => 'Santiago del Estero','Tierra del Fuego' => 'Tierra del Fuego','Tucuman' => 'Tucuman'); ?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('layout' => TbHtml::FORM_LAYOUT_INLINE));?>
   
<div class="row">
   <legend class="span">Datos Personales</legend>
</div>

<div class="row">
   <div class="span8 offset1">
      <div class="well">
         <div class="row">
            <?php echo $form->textFieldControlGroup( $model, 'nombre', array('groupOptions'=>array('class'=>'span3')) ); ?>
            <?php echo $form->textFieldControlGroup( $model, 'apellido', array('groupOptions'=>array('class'=>'span3'))); ?>
         </div>
         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'dni', array('groupOptions'=>array('class'=>'span3'))); ?>
            <?php echo $form->dropDownListControlGroup($model, 'sexo', array('M'=>'Masculino', 'F'=>'Femenino'),
                  array('groupOptions'=>array('class'=>'span2'))); ?>   
         </div>
         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'fecha_nac', array('readonly'=>'',
                  'groupOptions'=>array('class'=>'span3'))); ?>
            <?php echo $form->textFieldControlGroup($model, 'anio_residencia', array('groupOptions'=>array('class'=>'span3'))); ?>
         </div>
         <div class="row">
            <?php echo $form->dropDownListControlGroup($model, 'nacionalidad',
                  array('Argentino/a'=>'Argentino/a', 'Extranjero/a'=>'Extranjero/a'),
                  array('id'=>'nacionalidad-combo', 'groupOptions'=>array('class'=>'span3'))); ?>
            <?php echo $form->textFieldControlGroup($model, 'pais_nac',
                  array('groupOptions'=>array('id'=>'input-pais-nac', 'class'=>'span3'))); ?>
            <?php echo $form->dropDownListControlGroup($model, 'provincia_nac',$provincias,
                  array('groupOptions'=>array('id'=>'input-provincias-nac', 'class'=>'span3'))); ?>
         </div>
         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'localidad_nac',
                  array('groupOptions'=>array('id'=>'input-localidad-nac', 'class'=>'span3'))); ?>
         </div>
         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'telefono', 
                  array('prepend' => '02972', 'span'=>2, 'groupOptions'=>array('span'=>3))); ?>
         </div>
         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'celular_prefijo',
                  array('span'=>1, 'groupOptions'=>array('class'=>'span1'))); ?>
            <?php echo $form->textFieldControlGroup($model, 'celular',
                  array('prepend' => '15', 'span'=>2, 'groupOptions'=>array('span'=>3))); ?>
         </div>
         
      </div>
   </div>
</div>
<div class="row">
   <div class="span8 offset1">
      <div class="well">
            <div class="row">
               <?php echo $form->inlineCheckBoxListControlGroup($model, 'condicionesEspeciales',
                     $model->getCondicionesEspeciales(), array('groupOptions'=>array('class'=>'span8'))); ?>
            </div>
         </div>
      </div>   
</div>

<div class="row">
   <legend class="span">Situacion Economica</legend>
</div>
<div class="row">
   <div class="span8 offset1">
      <div class="well">
         <div class="row">
            <?php echo $form->dropDownListControlGroup($model, 'tipo_situacion_laboral_id', $model->getSituacionesLaborales(),
                  array('id'=>"situacion-laboral-combo", 'groupOptions'=>array('class'=>'span'))); ?>
         </div>
         <div id="detalle-ocupacion-container">
            <div class="row">
               <?php echo $form->inlineRadioButtonListControlGroup($model, 'relacion_dependencia',
                     array('Cuenta propista', 'Relacion de Dependencia'), array('groupOptions'=>array('class'=>'span8'))); ?>
            </div>
            <div class="row">
               <?php echo $form->inlineRadioButtonListControlGroup($model, 'formal', array('Informal', 'Formal'),
                     array('groupOptions'=>array('class'=>'span3'),)); ?>
            </div>
            <div class="row">
               <?php echo $form->textFieldControlGroup($model, 'ingresos_laborales', 
                     array('prepend' => '$', 'append' => '.00', 'span' => 1, 'style'=>"text-align:end", 'groupOptions'=>array('class'=>'span2'))); ?>
               <?php echo $form->textFieldControlGroup($model, 'ocupacion', array('groupOptions'=>array('class'=>'span'))); ?>
            </div>
         </div>
         
         <div class="row">
            <?php echo $form->textFieldControlGroup($model, 'ingresos_alimentos',
                  array('prepend' => '$', 'append' => '.00', 'span' => 1, 'style'=>"text-align:end", 'groupOptions'=>array('class'=>'span2'))); ?>
            <?php echo $form->textFieldControlGroup($model, 'ingresos_subsidio', 
                  array('prepend' => '$', 'append' => '.00', 'span' => 1, 'style'=>"text-align:end", 'groupOptions'=>array('class'=>'span3'))); ?>
         </div>
         <div class="row">&nbsp;</div>
         <div class="row">
            <div class="span offset5">
               <?php echo TbHtml::link('Cancelar', Yii::app()->createUrl("persona/admin"),
               array('class'=>'btn'));?>
            </div>
            <div class="span">
               <?php echo TbHtml::submitButton('Guardar', array('color'=>TbHtml::BUTTON_COLOR_SUCCESS)); ?>
            </div>
         </div>
      </div>
   </div>
</div>


<?php $this->endWidget();?>


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