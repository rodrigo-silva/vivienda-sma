<?php
class DomicilioManager extends CComponent {
   
   /**
    */
   public static function createDomicilio($form) {
      $domicilio = new Domicilio;
      $grupo = new GrupoConviviente;

      $domicilio->attributes = (array)$form;
      $domicilio->grupoConviviente = $grupo;
      if($domicilio->validates() && $domicilio->saveWithRelated('grupoConviviente')) {
         return $domicilio;
      } else {
         throw new CHttpException(500, 'Error de datos al guardar el domicilio');
      }
   }
}