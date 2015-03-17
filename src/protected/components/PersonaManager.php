<?php
/**
 * Clase de utilidad para manejar los datos de las entidad Persona, en tanto a su integridad. Existe la clase Persona que oficia
 * de DAO en cambio esta clase toma datos, regularmente provinientes de formularios y opera sobre persona y sus asociaciones.
 * Posee un ambiente TRANSACCIONAL. 
 */
class PersonaManager extends TransactionalManager {

   /**
    */
   public static function savePersona($personaForm) {
      $clorure = function() use($personaForm){
         $persona=new Persona;
         $laboral = new SituacionLaboral;

         $laboral->attributes = (array)$personaForm;         
         $persona->attributes= (array)$personaForm;
         $persona->situacionLaboral = $laboral;
         if($persona->save()) {
            $laboral->persona_id = $persona->id;
            if($laboral->save()) {
               return $persona;
            }
         }
         Yii::log(print_r($laboral->errors, true) . print_r($persona->errors, true), 'error');
         throw new CHttpException(400, 'Error en los datos al guardar Persona.');
      };
      
      return parent::doInTransaction($clorure);
   }

}
?>