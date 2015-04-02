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
         $economica = new SituacionEconomica;
         $laboral = new SituacionLaboral;
         $telFijo = new Telefono;
         $telCel = new Telefono;

         $laboral->attributes = (array)$personaForm;         
         $persona->attributes = (array)$personaForm;
         $economica->attributes = (array)$personaForm;
         
         $telFijo->prefijo = $personaForm->telefonoFijoPre;
         $telFijo->numero = $personaForm->telefonoFijo;
         $telCel->prefijo = $personaForm->telefonoCelularPre;
         $telCel->numero = $personaForm->telefonoCelular;

         if($persona->save()) {
            $telFijo->persona_id = $persona->id;
            $telCel->persona_id = $persona->id;
            if($telFijo->validate()){
               $telFijo->save();
            }
            if($telCel->validate()){
               $telCel->save();
            }

            $economica->persona_id = $persona->id;
            if($economica->save()) {
               $laboral->situacion_economica_id = $economica->id;
               if($laboral->save()) {
                  if($personaForm->condicionesEspeciales != NULL) {
                     foreach($personaForm->condicionesEspeciales as $key => $value) {
                        Yii::app()->db->createCommand()->insert('persona_condicion_especial',
                                        array('persona_id'=>$persona->id, 'condicion_especial_id' => $value));

                     }
                  }
                  
                  return $persona;
               }
            }
         }
         TransactionalManager::logModelErrors(array($persona, $economica, $laboral));
         throw new CHttpException(400, 'Error en los datos al guardar Persona.');
      };
      
      return parent::doInTransaction($clorure);
   }

}
?>