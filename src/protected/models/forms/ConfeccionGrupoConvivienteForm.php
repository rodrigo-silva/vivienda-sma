<?php
class ConfeccionGrupoConvivienteForm extends CFormModel {

   public $banios = array(array('interno'=>0, 'completo'=>0, 'es_letrina'=>0));
   public $convivientes = array();
   public $observaciones = "";
   public $servicios = array();
   public $action = "/Solicitud/confeccionGrupoConviviente";

   /**
    * Reglas de validacion general
    */
   public function rules() {
      return array(
         array('banios, convivientes, observaciones, servicios', 'safe')
      );
   }
}