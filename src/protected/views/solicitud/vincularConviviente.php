<?php

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm');
   
   echo $form->uneditableFieldControlGroup($model, 'dni');
   echo $form->uneditableFieldControlGroup($model, 'nombre');
   echo $form->uneditableFieldControlGroup($model, 'apellido');
   echo TbHtml::submitButton('Agregar');

   $this->endWidget();
?>