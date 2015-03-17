<?php

class SolicitudManager extends TransactionalManager {
   /**
    */
   public static function saveSolicitudBase($solicitudBaseForm, $titular) {
      $domicilio = self::findDomicilio($solicitudBaseForm);
      
      $closure = function() use($solicitudBaseForm, $titular, $domicilio) {
         if ($domicilio == null) {
            $domicilio = SolicitudManager::createDomicilio($solicitudBaseForm);
         }
        
         $viviendaActual = new ViviendaActual;
         $viviendaActual->attributes = (array)$solicitudBaseForm;
         if($viviendaActual->save()) {
            $solicitud = new Solicitud('new');
            $solicitud->fecha = date('Y-m-d');
            $solicitud->attributes = (array)$solicitudBaseForm;
            
            $solicitud->vivienda_actual_id = $viviendaActual->id;
            $solicitud->titular_id = $titular->id;
            $solicitud->grupo_conviviente_id = $domicilio->grupoConviviente->id;
            if($solicitud->save()) {
               return $solicitud;
            }
         }
         Yii:log(print_r($viviendaActual->errors, true), print_r($solicitud->errors, true));
         throw new CHttpException(400, "Error de datos en la solicitud");
      };

      return parent::doInTransaction($closure);      
   }

   /**
    */
   protected static function createDomicilio($solicitudBaseForm) {
     
      $domicilio = new Domicilio;
      $grupo = new GrupoConviviente;
      $domicilio->attributes = (array)$solicitudBaseForm;
      if($domicilio->save()) {
         $grupo->domicilio_id = $domicilio->id;
         if($grupo->save()) {
            return $domicilio;
         }
      }
      Yii:log(print_r($domicilio->errors, true), 'error');
      throw new CHttpException(400, "Error de datos en el domicilio");
      
   }

   /**
    */
   private static function findDomicilio($solicitudBaseForm) {
      $q = new CDbCriteria();
      $q->addColumnCondition(array(
            'LOWER(calle)' => strtolower($solicitudBaseForm->calle),
            'LOWER(altura)' => strtolower($solicitudBaseForm->altura),
            'LOWER(piso)' => strtolower($solicitudBaseForm->piso),
            'LOWER(departamento)' => strtolower($solicitudBaseForm->departamento),
            'LOWER(casa)' => strtolower($solicitudBaseForm->casa),
            'LOWER(lote)' => strtolower($solicitudBaseForm->lote),
      ));
      
      return Domicilio::model()->find($q);
   }

}
