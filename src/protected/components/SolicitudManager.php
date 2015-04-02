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

         
         $solicitud = new Solicitud('new');
         $solicitud->fecha = date('Y-m-d');
         $solicitud->attributes = (array)$solicitudBaseForm;
         $solicitud->titular_id = $titular->id;
         $solicitud->grupo_conviviente_id = $domicilio->grupoConviviente->id;
         
         if($solicitudBaseForm->es_alquiler == 'true') {
            $condicionAlquiler = new CondicionAlquiler;
            $condicionAlquiler->attributes = (array)$solicitudBaseForm;
            if($condicionAlquiler->save()) {
               $solicitud->condicion_alquiler_id = $condicionAlquiler->id;
            } else {
               TransactionalManager::logModelErrors(array($condicionAlquiler));
               throw new CHttpException(400, "Error de datos en la solicitud");
            }
         }

         $solicitud->numero = date("y") . strrev($titular->id) . (time() - strtotime(date('Y-m-d')));
         if($solicitud->save()) {
            return $solicitud;
         }
         TransactionalManager::logModelErrors(array($solicitud));
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
      TransactionalManager::logModelErrors(array($domicilio));
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
