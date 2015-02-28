<?php
   $form = $this->beginWidget('bootstrap.widgets.TbActiveForm');

   echo $form->textFieldControlGroup($model, 'nombre');
   echo $form->textFieldControlGroup($model, 'apellido');
   echo $form->textFieldControlGroup($model, 'dni');
   echo $form->dropDownListControlGroup($model, 'sexo', array('M'=>'Masculino', 'F'=>'Femenino'));
   echo $form->textFieldControlGroup($model, 'fecha_nac');
   echo $form->dropDownListControlGroup($model, 'pais_nac_id',$model->getPaises());
   echo $form->dropDownListControlGroup($model, 'provincia_nac_id',$model->getProvincias());
   echo $form->dropDownListControlGroup($model, 'localidad_nac_id',$model->getLocalidades());
   echo $form->textFieldControlGroup($model, 'nacionalidad');
   echo $form->textFieldControlGroup($model, 'telefonoFijoPre');
   echo $form->textFieldControlGroup($model, 'telefonoFijo');
   echo $form->textFieldControlGroup($model, 'telefonoCelularPre');
   echo $form->textFieldControlGroup($model, 'telefonoCelular');
   echo $form->inlineRadioButtonListControlGroup($model, 'trabaja', array("No",'Si'));
   echo $form->inlineRadioButtonListControlGroup($model, 'formal', array("No",'Si'));
   echo $form->inlineRadioButtonListControlGroup($model, 'jubilado_pensionado', array("No",'Si'));
   echo $form->textFieldControlGroup($model, 'ingreso_neto_mensual');
   echo $form->inlineCheckBoxListControlGroup($model, 'condicionesEspeciales', $model->getCondicionesEspeciales());

   echo TbHtml::submitButton('Crear');
   $this->endWidget();

   Yii::app()->clientScript->registerScript('script',
<<<JS
       jQuery('#PersonaForm_fecha_nac').datepicker({dateFormat: "yy-mm-dd", changeYear:true, yearRange:"c-100:+0",
                                                 defaultDate: "-50y"}).datepicker('widget').css('font-size', '13px');
JS
   , CClientScript::POS_READY);

?>