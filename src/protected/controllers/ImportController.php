<?php
class ImportController extends Controller
{

   public function actionImport() {
      return;
      set_time_limit(0);
      $i = 0; //puntero donde estoy
      $c = new CDbCriteria;
      // $c->offset = 3292;
      $c->order = 'dniTitular';
      // $c->limit = 3;
      $records = Import::model()->findAll($c);

      while( $i < count($records) ) {
         $convivientes = array();
         $dniTitular = $records[$i]['dniTitular'];

         while( $i < count($records) && $dniTitular == $records[$i]['dniTitular'] ) {
            $id = $records[$i]['id'];
            Yii::trace("Registro numero $i con id $id", 'com.wazoo.import');
            //save pipol en i
            $personaForm = new PersonaForm;
            $personaForm->attributes = $records[$i]['attributes'];
            PersonaManager::savePersona($personaForm);
            if( $dniTitular != $personaForm->dni ) {
            // SI NO ES TITULAR la agregas al array de convivientes como solicitante
               array_push( $convivientes, array('dni' => $personaForm->dni, 
                                                'vinculo' => 'Sin vinculo',
                                                'solicitante' => '1',
                                                'cotitular' => '0')
               );  
            }
            $i++;
         }
         $baseForm = new SolicitudBaseForm('post');
         $baseForm->attributes = $records[$i-1]['attributes'];
         $baseForm->fecha = $records[$i-1]['attributes']['fecha'];

         //buscas domicilio en i-1. Si existe agregas a las personas en la list de convivientes
         $domicilio = $this->findDomicilio($baseForm);
         if( !is_null($domicilio) ) {
            $otros = $domicilio->grupoConviviente->personas;
            foreach ( $otros as $chabon ) {
               array_push( $convivientes, array('dni' => $chabon->dni, 
                                                'vinculo' => 'Sin vinculo',
                                                'solicitante' => '0',
                                                'cotitular' => '0')
               ); 
            }
         }

         $titu = Persona::model()->findByAttributes( array('dni'=>$dniTitular) );
         //salvas la solicitud
         $laSolicitud = SolicitudManager::saveSolicitudBase($baseForm, $titu);
         
         $grupoConvivienteForm = new ConfeccionGrupoConvivienteForm;
         $grupoConvivienteForm->convivientes = $convivientes;
         $grupoConvivienteForm->banios = array(array('interno'=>1, 'completo'=>1, 'es_letrina'=>0));

         if( is_null($domicilio) ) {
            SolicitudManager::saveGrupoConvivienteInfo($grupoConvivienteForm, $laSolicitud);
         } else {
            SolicitudManager::updateGrupoConvivienteInfo($grupoConvivienteForm, $laSolicitud);
         }
      }

   }


   /**
    */
   private function findDomicilio($baseForm) {
      $q = new CDbCriteria();
      $q->addColumnCondition(array(
            'LOWER(calle)' => strtolower($baseForm->calle),
            'LOWER(altura)' => strtolower($baseForm->altura),
            'LOWER(piso)' => strtolower($baseForm->piso),
            'LOWER(departamento)' => strtolower($baseForm->departamento),
            'LOWER(casa)' => strtolower($baseForm->casa),
            'LOWER(puerta)' => strtolower($baseForm->puerta),
            'LOWER(cruce_calle_1)' => strtolower($baseForm->cruce_calle_1),
            'LOWER(cruce_calle_2)' => strtolower($baseForm->cruce_calle_2),
            'LOWER(manzana)' => strtolower($baseForm->manzana),
            'LOWER(barrio)' => strtolower($baseForm->barrio),
            'LOWER(edificio)' => strtolower($baseForm->edificio),
            'LOWER(lote)' => strtolower($baseForm->lote),
      ));

      return Domicilio::model()->find($q);
   }

}