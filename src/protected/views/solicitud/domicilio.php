<?php
   $form = $this->beginWidget('bootstrap.widgets.TbActiveForm');
   
   echo $form->textFieldControlGroup($model, 'calle');
   echo $form->textFieldControlGroup($model, 'altura');
   echo $form->textFieldControlGroup($model, 'piso');
   echo $form->textFieldControlGroup($model, 'departamento');
   echo $form->textFieldControlGroup($model, 'casa');
   echo $form->textFieldControlGroup($model, 'lote');
   echo $form->textAreaControlGroup($model, 'observaciones');

   echo TbHtml::submitButton('Continuar');

   $this->endWidget();
?>