<?php
/**
 * Clase de utilidad para manejar los datos de las entidad Persona, en tanto a su integridad. Existe la clase Persona que oficia
 * de DAO en cambio esta clase toma datos, regularmente provinientes de formularios y opera sobre persona y sus asociaciones.
 * Posee un ambiente TRANSACCIONAL. 
 */
class PersonaManager extends CComponent {

   /**
    */
   public static function savePersona($personaForm) {
      $persona=new Persona;
      $laboral = new SituacionLaboral;

      $laboral->attributes = (array)$personaForm;         
      $persona->attributes= (array)$personaForm;
      $persona->situacionLaboral = $laboral;

      
      if($persona->validate() && $laboral->validate()
         && $persona->saveWithRelated(array('situacionLaboral', 'condicionesEspeciales'))) {
         
         return $persona;
      } else {
         throw new CHttpException(500,'Error de datos al guardar los datos de la Persona.');
      }

   }
}
?>