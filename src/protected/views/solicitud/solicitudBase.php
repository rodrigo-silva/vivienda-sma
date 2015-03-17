<?php
   $form = $this->beginWidget('bootstrap.widgets.TbActiveForm');
   
   echo $form->textFieldControlGroup($model, 'calle');
   echo $form->textFieldControlGroup($model, 'altura');
   echo $form->textFieldControlGroup($model, 'piso');
   echo $form->textFieldControlGroup($model, 'departamento');
   echo $form->textFieldControlGroup($model, 'casa');
   echo $form->textFieldControlGroup($model, 'lote');
   echo $form->textAreaControlGroup($model, 'observaciones');
echo '<hr/>';

   echo $form->dropDownListControlGroup($model, 'tipo_solicitud_id', $model->getTipoSolicitudes());
   echo $form->dropDownListControlGroup($model, 'condicion_lote_id', $model->getCondicionesLote());
   echo $form->dropDownListControlGroup($model, 'tipo_vivienda_id', $model->getTiposVivienda());
   echo $form->dropDownListControlGroup($model, 'condicion_uso_id', $model->getCondicionesDeUso());
   echo $form->inlineRadioButtonListControlGroup($model, 'formal', array("Formal", 'Informal'));
   echo $form->inlineRadioButtonListControlGroup($model, 'costo_superior', array('Superior', 'Inferior'));
   
   echo TbHtml::submitButton('Continuar');

   $this->endWidget();
?>