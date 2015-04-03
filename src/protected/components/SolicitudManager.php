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

   public static function saveGrupoConvivienteInfo($form, $solicitud, $titular) {
      //vivienda actual
      $viviendaActual = new ViviendaActual;
      $viviendaActual->observaciones = $form->observaciones;
      $viviendaActual->domicilio_id = $solicitud->domicilio->id;
      if(!$viviendaActual->save()) {
         TransactionalManager::logModelErrors(array($viviendaActual));
         throw new CHttpException(400, "Error de datos en la solicitud");
      }

      //Banios
      foreach ($form->banios as $value) {
         $banio = new Banio;
         $banio->interno = $value->interno;
         $banio->completo = $value->completo;
         $banio->es_letrina = $value->letrina;
         if(!$banio->save()) {
            TransactionalManager::logModelErrors(array($banio));
            throw new CHttpException(400, "Error de datos en la solicitud");
         }
         Yii::app()->db->createCommand()->insert('vivienda_actual_banio',
                                        array('vivienda_actual_id'=>$$viviendaActual->id, 'banio_id' => $banio->id));

      }

      //servicios
      foreach ($form->servicios as $value) {
         $servicio = new Servicio;
         $servicio->tipo_servicio_id = $value->tipo_servicio_id;
         $servicio->medidor = $value->medidor;
         $servicio->compartido = $value->compartido;

         if(!$servicio->save()) {
            TransactionalManager::logModelErrors(array($servicio));
            throw new CHttpException(400, "Error de datos en la solicitud");
         }
         Yii::app()->db->createCommand()->insert('vivienda_actual_servicio',
                                        array('vivienda_actual_id'=>$$viviendaActual->id, 'servicio_id' => $servicio->id));
      }

      // limpiar grupos
      Persona::model()->updateAll(array('grupo_conviviente_id'=>NULL, 'grupo_conviviente_id=:id', array(':id' =>$solicitud->grupoConviviente->id)));
      Yii::app()->db->createCommand()->delete('grupo_solicitante', 'solicitud_id=:id', array(':id'=>$solicitud->id));
      
      //convivientes
      foreach ($form->convivientes as $value) {
         
      }

      $sql = "INSERT INTO vinculo (persona_id, familiar_id, tipo) VALUES( (select persona.id from persona where persona.dni = :pdni), (select persona.id from persona where persona.dni = :fdni), :vinculo)";
      $command = Yii::app()->db->createCommand($sql);
      //$command->bindParam(":pdni", 99999)
      //$command->execute();
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
