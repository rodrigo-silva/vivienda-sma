<?php
class ConfeccionGrupoConvivienteForm extends CFormModel {

   public $banios;
   public $convivientes;
   public $observaciones;
   public $servicios;

   /**
    * Reglas de validacion general
    */
   public function rules() {
      return array(
         array('banios, convivientes, observaciones, servicios', 'safe')
      );
   }
}