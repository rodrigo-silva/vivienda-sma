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

         $solicitud = new Solicitud;
         $solicitud->fecha = date('Y-m-d');
         $solicitud->attributes = (array)$solicitudBaseForm;
         $solicitud->titular_id = $titular->id;
         $solicitud->grupo_conviviente_id = $domicilio->grupoConviviente->id;
         
         if($solicitudBaseForm->es_alquiler) {
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
            $titular->grupo_conviviente_id = $domicilio->grupoConviviente->id;
            $titular->solicitud_id = $solicitud->id;
            if($titular->save()) {
               return $solicitud;
            }
         }
         
         TransactionalManager::logModelErrors(array($solicitud, $titular));
         throw new CHttpException(400, "Error de datos en la solicitud");
      };

      return parent::doInTransaction($closure);      
   }

   /**
    */
   public static function updateSolicitudBase($solicitudBaseForm, $solicitud) {
      $closure = function() use($solicitudBaseForm, $solicitud) {
         $oldCondicionAlquiler = $solicitud->condicionAlquiler;

         $solicitud->attributes = (array)$solicitudBaseForm;
         $solicitud->domicilio->attributes = (array)$solicitudBaseForm;

         if($solicitudBaseForm->es_alquiler == 'true') {
            $condicionAlquiler = new CondicionAlquiler;
            $condicionAlquiler->attributes = (array)$solicitudBaseForm;
            if($condicionAlquiler->save()) {
               $solicitud->condicion_alquiler_id = $condicionAlquiler->id;
            } else {
               TransactionalManager::logModelErrors(array($condicionAlquiler));
               throw new CHttpException(400, "Error de datos en la solicitud");
            }
         } else {
            $solicitud->condicion_alquiler_id = NULL;
         }

         if($solicitud->save() && $solicitud->domicilio->save()) {
            if (!is_null($oldCondicionAlquiler)) $oldCondicionAlquiler->delete();
            return $solicitud;
         }
         TransactionalManager::logModelErrors(array($solicitud));
         throw new CHttpException(400, "Error de datos en la solicitud");
      };

      return parent::doInTransaction($closure);      
   }

   /**
    *
    */
   public static function saveGrupoConvivienteInfo($form, $solicitud) {
      $closure = function() use($form, $solicitud) {
         $solicitud->estado_administrativo_solicitud_id =
               EstadoAdministrativoSolicitud::model()->findByAttributes(array('nombre'=>$form->estado))->id;
         //vivienda actual ya existe
         $viviendaActual = $solicitud->domicilio->viviendaActual;
         $viviendaActual->observaciones = $form->observaciones;
         $viviendaActual->save();
         //Banios
         foreach ($form->banios as $value) {
            $banio = new Banio;
            $banio->interno = $value['interno'];
            $banio->completo = $value['completo'];
            $banio->es_letrina = $value['es_letrina'];
            $banio->vivienda_actual_id = $viviendaActual->id;
            if(!$banio->save()) {
               TransactionalManager::logModelErrors(array($banio));
               throw new CHttpException(400, "Error de datos en la solicitud");
            }
         }

         if(!is_null($form->servicios)) {
            //servicios
            foreach ($form->servicios as $value) {
               $servicio = new Servicio;
               $servicio->tipo_servicio_id = $value['tipo_servicio_id'];
               $servicio->medidor = $value['medidor'];
               $servicio->compartido = $value['compartido'];
               $servicio->vivienda_actual_id = $viviendaActual->id;
               if(!$servicio->save()) {
                  TransactionalManager::logModelErrors(array($servicio));
                  throw new CHttpException(400, "Error de datos en la solicitud");
               }
            }
         }
         
         //convivientes
         foreach ($form->convivientes as $value) {
            $conviviente = Persona::model()->find('dni=:dni', array(':dni' =>$value['dni']));
            $conviviente->grupo_conviviente_id = $solicitud->grupoConviviente->id;
            if($value['solicitante'] == 1) {
               $conviviente->solicitud_id = $solicitud->id;
            }
            $conviviente->update();
            
            if($value['cotitular'] == 1) {
               $solicitud->cotitular_id = $conviviente->id;
            }
            if ($value['vinculo'] != "Sin vinculo") {
               Yii::app()->db->createCommand()->insert('vinculo',
                                              array('persona_id'=>$conviviente->id,
                                                    'familiar_id' => $solicitud->titular->id,
                                                    'vinculo'=>$value['vinculo']));
               if($solicitud->titular->sexo == 'M') {
                  $retrogrado = VinculosUtil::getVinculoMasculinoRetrogrado($value['vinculo']);
               } else {
                  $retrogrado = VinculosUtil::getVinculoFemeninoRetrogrado($value['vinculo']);
               }
               Yii::app()->db->createCommand()->insert('vinculo',
                                              array('persona_id'=>$solicitud->titular->id,
                                                    'familiar_id' => $conviviente->id,
                                                    'vinculo'=>$retrogrado));
               
            }
         }
         $solicitud->estado_administrativo_solicitud_id =
               EstadoAdministrativoSolicitud::model()->findByAttributes(array('nombre'=>$form->estado))->id;
         $solicitud->update();
         
         return $solicitud;
      };

      return parent::doInTransaction($closure);
   }

      /**
    *
    */
   public static function updateGrupoConvivienteInfo($form, $solicitud) {
      $closure = function() use($form, $solicitud) {
         $solicitud->estado_administrativo_solicitud_id =
               EstadoAdministrativoSolicitud::model()->findByAttributes(array('nombre'=>$form->estado))->id;
         //vivienda actual
         $solicitud->domicilio->viviendaActual->observaciones = $form->observaciones;
         $solicitud->domicilio->viviendaActual->save();

         //Banios
         Yii::app()->db->createCommand()->delete('banio', 'vivienda_actual_id=:id', array(':id'=> $solicitud->domicilio->viviendaActual->id));
         foreach ($form->banios as $value) {
            $banio = new Banio;
            $banio->interno = $value['interno'];
            $banio->completo = $value['completo'];
            $banio->es_letrina = $value['es_letrina'];
            $banio->vivienda_actual_id = $solicitud->domicilio->viviendaActual->id;

            if(!$banio->save()) {
               TransactionalManager::logModelErrors(array($banio));
               throw new CHttpException(400, "Error de datos en la solicitud");
            }

         }

         //Servicios
         Yii::app()->db->createCommand()->delete('servicio', 'vivienda_actual_id=:id', array(':id'=> $solicitud->domicilio->viviendaActual->id));
         if(!is_null($form->servicios)) {
            foreach ($form->servicios as $value) {
               $servicio = new Servicio;
               $servicio->tipo_servicio_id = $value['tipo_servicio_id'];
               $servicio->medidor = $value['medidor'];
               $servicio->compartido = $value['compartido'];
               $servicio->vivienda_actual_id = $solicitud->domicilio->viviendaActual->id;
               if(!$servicio->save()) {
                  TransactionalManager::logModelErrors(array($servicio));
                  throw new CHttpException(400, "Error de datos en la solicitud");
               }
            }
         }

         // limpiar grupos
         Persona::model()->updateAll(array('grupo_conviviente_id'=>NULL), 'grupo_conviviente_id=:id AND id !=:titularId', 
                                     array(':id' =>$solicitud->grupoConviviente->id, ':titularId'=>$solicitud->titular->id));
         
         Persona::model()->updateAll(array('solicitud_id'=>NULL), 'solicitud_id=:id AND id !=:titularId',
                                     array(':id' =>$solicitud->id, ':titularId'=>$solicitud->titular->id));

         Yii::app()->db->createCommand()->delete('vinculo', 'persona_id=:id', array(':id'=>$solicitud->titular->id));
         Yii::app()->db->createCommand()->delete('vinculo', 'familiar_id=:id', array(':id'=>$solicitud->titular->id));
         
         //convivientes
         $solicitud->cotitular_id = NULL;
         foreach ($form->convivientes as $value) {
            $conviviente = Persona::model()->find('dni=:dni', array(':dni' =>$value['dni']));
            $conviviente->grupo_conviviente_id = $solicitud->grupoConviviente->id;
            if($value['solicitante'] == 1) {
               $conviviente->solicitud_id = $solicitud->id;
            }
            $conviviente->update();

            if($value['cotitular'] == 1) {
               $solicitud->cotitular_id = $conviviente->id;
            }
            if ($value['vinculo'] != "Sin vinculo") {
               Yii::app()->db->createCommand()->insert('vinculo',
                                              array('persona_id'=>$conviviente->id,
                                                    'familiar_id' => $solicitud->titular->id,
                                                    'vinculo'=>$value['vinculo']));
               if($solicitud->titular->sexo == 'M') {
                  $retrogrado = VinculosUtil::getVinculoMasculinoRetrogrado($value['vinculo']);
               } else {
                  $retrogrado = VinculosUtil::getVinculoFemeninoRetrogrado($value['vinculo']);
               }
               Yii::app()->db->createCommand()->insert('vinculo',
                                              array('persona_id'=>$solicitud->titular->id,
                                                    'familiar_id' => $conviviente->id,
                                                    'vinculo'=>$retrogrado));
               
            }
         }

         $solicitud->update();
         return $solicitud;
      };

      return parent::doInTransaction($closure);
   }

   /**
    */
   public static function archivarSolicitud($archivarForm) {
      $closure = function() use($archivarForm) {
         $original = Solicitud::model()->with(array('domicilio', 'domicilio.viviendaActual'))->find("numero=:numero",
                                      array(':numero'=>$archivarForm->numero));
         if (is_null($original)) {
            throw new CHttpException(404, "No existe la solicitud numero: $archivarForm->numero");
         }
         $archivo = new SolicitudArchivo;
         $archivo->attributes = $original->attributes;
         $archivo->domicilio_id = $original->domicilio->id;
         $archivo->observaciones_vivienda = $original->domicilio->viviendaActual->observaciones;
         $archivo->attributes = (array)$archivarForm;
         if(!$archivo->save()) {
            TransactionalManager::logModelErrors(array($archivo));
            throw new CHttpException(400, "Error de datos en la solicitud");
         }

         if(!is_null($original->grupoConviviente->personas)){
            foreach ($original->grupoConviviente->personas as $value) {
               $convivienteArchivo = new ConvivienteArchivo();
               $convivienteArchivo->solicitud_archivo_id = $archivo->id;
               $convivienteArchivo->persona_id = $value->id;
               if(!is_null($value->solicitud) && $value->solicitud->id == $original->id) {
                  $convivienteArchivo->es_solicitante = 1;
               } else {
                  $convivienteArchivo->es_solicitante = 0;
               }
               $convivienteArchivo->save();
            }
         } 

         //Banios
         foreach ($original->domicilio->viviendaActual->banios as $value) {
            $banio = new BanioArchivo;
            $banio->interno = $value['interno'];
            $banio->completo = $value['completo'];
            $banio->es_letrina = $value['es_letrina'];
            $banio->solicitud_archivo_id = $archivo->id;
            $banio->save();
         }

         if(!is_null($original->domicilio->viviendaActual->servicios)) {
            //servicios
            foreach ($original->domicilio->viviendaActual->servicios as $value) {
               $servicio = new ServicioArchivo;
               $servicio->tipo_servicio_id = $value['tipo_servicio_id'];
               $servicio->medidor = $value['medidor'];
               $servicio->compartido = $value['compartido'];
               $servicio->solicitud_archivo_id = $archivo->id;
               $servicio->save();
            }
         }

         //remove solicitud
         Persona::model()->updateAll(array('solicitud_id'=>NULL), 'solicitud_id=:id ', array(':id' =>$original->id));
         $original->delete();

         return $archivo;
      };

      return parent::doInTransaction($closure);

   }

   /**
    */
   protected static function createDomicilio($solicitudBaseForm) {
     
      $domicilio = new Domicilio;
      $grupo = new GrupoConviviente;
      $viviendaActual = new ViviendaActual;
      
      $domicilio->attributes = (array)$solicitudBaseForm;
      if($domicilio->save()) {
         $viviendaActual->domicilio_id = $domicilio->id;
         $viviendaActual->save();
        
         $grupo->domicilio_id = $domicilio->id;
         $grupo->save();

         return $domicilio;
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
            'LOWER(puerta)' => strtolower($solicitudBaseForm->puerta),
            'LOWER(cruce_calle_1)' => strtolower($solicitudBaseForm->cruce_calle_1),
            'LOWER(cruce_calle_2)' => strtolower($solicitudBaseForm->cruce_calle_2),
            'LOWER(manzana)' => strtolower($solicitudBaseForm->manzana),
            'LOWER(barrio)' => strtolower($solicitudBaseForm->barrio),
            'LOWER(estancia)' => strtolower($solicitudBaseForm->estancia),
            'LOWER(lote)' => strtolower($solicitudBaseForm->lote),
      ));
      
      return Domicilio::model()->find($q);
   }

}
