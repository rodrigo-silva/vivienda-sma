<?php

class SolicitudController extends Controller {

   private static $PERSONA_KEY = 'persona-solicitud';
   private static $DOMICILIO_KEY = 'domicilio-solicitud';
   private static $SOLICITUD_KEY = 'solicitud';

   public function actionView($id) {
      $this->render("");
   }

   /**
    *
    */
   public function actionUpdate($id) {
      $solicitud = Solicitud::model()->with(
         array('domicilio', 'domicilio.viviendaActual.servicios', 'domicilio.viviendaActual.banios',
               'condicionUso'))->findByPk($id);
      if($solicitud===null) {
         throw new CHttpException(404,'Esta intentando actualizar una Solicitud inexistente en el sistema');
      }

      Yii::app()->user->setState(self::$PERSONA_KEY, $solicitud->titular);
      Yii::app()->user->setState(self::$SOLICITUD_KEY, $solicitud);

      $request = Yii::app()->request;
      $baseForm = new SolicitudBaseForm('post');
      $grupoConvivienteForm = new ConfeccionGrupoConvivienteForm;
      $grupoConvivienteForm->action = $request->url;
      if ($request->isPostRequest) {
         if( !is_null($request->getPost('SolicitudBaseForm')) ) { //update base
            $baseForm->attributes = $request->getPost('SolicitudBaseForm');
            if($baseForm->validate()) {
               if($this->canUpdateDomicilio($baseForm, $solicitud)) {
                  SolicitudManager::updateSolicitudBase($baseForm, $solicitud);
               } else {
                  Yii::app()->user->setFlash('generalError', "Los nuevos valores para el domicilio, configuran un domicilio existente en el sistema, el cual ya posee configuraciones de Grupo conviviente y detalles de la vivienda.");
               }
            }
         } else if(!is_null($request->getPost('ConfeccionGrupoConvivienteForm'))) {
            $grupoConvivienteForm->attributes = $request->getPost('ConfeccionGrupoConvivienteForm');
            SolicitudManager::updateGrupoConvivienteInfo($grupoConvivienteForm, $solicitud);
            $this->redirect($request->url);
         }
      } else { //GET
         $baseForm->attributes = $solicitud->attributes;
         $baseForm->attributes = $solicitud->domicilio->attributes;
         if (!is_null($solicitud->condicionAlquiler)) {
            $baseForm->attributes = $solicitud->condicionAlquiler->attributes;
         }
         $this->populateGrupoConvivienteForm($grupoConvivienteForm, $solicitud);
      }
      $vinculosMasculinos = VinculosUtil::getVinculosMasculinos(); 
      $vinculosMasculinos = array_combine($vinculosMasculinos, $vinculosMasculinos);
      $vinculosFemeninosList = array_combine(VinculosUtil::getVinculosFemeninos(), VinculosUtil::getVinculosFemeninos());
     
      $this->render('update',
         array('baseForm' => $baseForm,
               'findPersonaForm'=> new SolicitudFindUserForm,
               'confeccionGrupoConvivienteForm' => $grupoConvivienteForm,
               'vinculosFemeninosList' => $vinculosFemeninosList,
               'vinculosMasculinosList' => $vinculosMasculinos,
               'solicitud' => $solicitud
         )
      );

   }
   /**
    * Punto de entrada para crear una solicitud. Busca la Persona para asociar como titular. Si no existe redirecciona a crearla
    */
   public function actionNew() {
      $request = Yii::app()->request;
      $form = new SolicitudFindUserForm;
      
      if ($request->isPostRequest) {
         $form->attributes = $request->getPost('SolicitudFindUserForm');
         if ($form->validate()) {
            $persona = $this->findPersona($form);
            if ($persona != null) {
               if($persona->solicitud_id == null) {
                  Yii::app()->user->setState(self::$PERSONA_KEY, $persona);
                  if($persona->grupo_conviviente_id == null) {
                     $this->redirect("solicitudBase");
                  } else {
                     Yii::app()->user->setState(self::$DOMICILIO_KEY, $persona->domicilio);
                     $this->redirect('grupoExistente');
                  }
               } else {
                  Yii::app()->user->setFlash('warning', "$persona->nombre $persona->apellido figura vinculado/a a la solicitud numero ". $persona->solicitud->numero. ". Debe desvincularse para generar una solicitud en su nombre." );
               }
            } else {
               $this->redirect("altaPersona");
            }
         }
      }
     
      $this->render('new', array('model'=> $form));
   }
   

   /**
    * Crea una Persona y redirecciona para seguir con el flujo
    */
   public function actionAltaPersona() {
      $request = Yii::app()->request;
      $form = new PersonaForm("new");
      if($request->isPostRequest) {
         $form->attributes = $request->getPost('PersonaForm');
         if($form->validate()) {
            Yii::app()->user->setState(self::$PERSONA_KEY, PersonaManager::savePersona($form));
            $this->redirect('solicitudBase');
         }
      }
      $this->render('altaPersona', array('model'=>$form));
   }

   /**
    */
   public function actionSolicitudBase() {
      $titular = $this->getTitularInSession();

      $request = Yii::app()->request;
      $form = new SolicitudBaseForm('post');
      if($request->isPostRequest) {
         $form->attributes = $request->getPost('SolicitudBaseForm');
         if($form->validate()) {
            $domicilio = $this->findDomicilio($form);
            if(is_null($domicilio)) {
               Yii::app()->user->setState(self::$SOLICITUD_KEY, SolicitudManager::saveSolicitudBase($form, $titular));
               Yii::app()->user->setState(self::$PERSONA_KEY, NULL);
               $this->redirect('confeccionGrupoConviviente');  
            } else {
               Yii::app()->user->setState(self::$DOMICILIO_KEY, $domicilio);
               $this->redirect('grupoExistente');
            }
         }
      }
      $this->render('solicitudBase', array('model'=>$form));        
   }

   /**
    */
   public function actionGrupoExistente() {
      $request = Yii::app()->request;
      $titular = $this->getTitularInSession();
      if($request->isPostRequest) {
         if($request->getPost('desvincular')) {
            $titular->grupo_conviviente_id = NULL;
            $titular->save();
            $this->redirect('solicitudBase');
         } else {
            $form = new SolicitudBaseForm('post');
            $form->attributes = Yii::app()->user->getState(self::$DOMICILIO_KEY)->attributes;
            $form->tipo_vivienda_id = 1;
            $form->tipo_solicitud_id = 1;
            $form->condicion_lote_id = 1;
            $form->condicion_uso_id = 1;
            $form->es_alquiler = 0;
            $solicitud = SolicitudManager::saveSolicitudBase($form, $titular);
            $this->redirect('/solicitud/update/' . $solicitud->id);
         }
      }
      $this->render("grupoExistente", array("titular" => $titular, 'domicilio' =>Yii::app()->user->getState(self::$DOMICILIO_KEY)));
   }

   /**
    */
   public function actionConfeccionGrupoConviviente() {
      $request = Yii::app()->request;
      $solicitud = Yii::app()->user->getState(self::$SOLICITUD_KEY);
      $form = new ConfeccionGrupoConvivienteForm;
      
      if ($request->isPostRequest) {
         $form->attributes = $request->getPost("ConfeccionGrupoConvivienteForm");
         SolicitudManager::saveGrupoConvivienteInfo($form, $solicitud);
         Yii::app()->user->setState(self::$SOLICITUD_KEY, NULL);
         $this->redirect('/solicitud/admin');
      }

      $vinculosMasculinos = VinculosUtil::getVinculosMasculinos(); 
      $vinculosFemeninos = VinculosUtil::getVinculosFemeninos(); 
      $vinculosMasculinos = array_combine($vinculosMasculinos, $vinculosMasculinos);
      $vinculosFemeninos = array_combine($vinculosFemeninos, $vinculosFemeninos);
     
      $this->render('confeccionGrupoConviviente',
         array('findPersonaForm'=> new SolicitudFindUserForm,
               'confeccionGrupoConvivienteForm' => $form,
               'vinculosFemeninosList' => $vinculosFemeninos,
               'vinculosMasculinosList' => $vinculosMasculinos,
               'solicitud' => $solicitud
         )
      );
   }

   /**
    */
   public function action_getConviviente() {
      $request = Yii::app()->request;
      $form = new SolicitudFindUserForm;
      $titular = Yii::app()->user->getState(self::$PERSONA_KEY);
      
      if ($request->isPostRequest) {
         $form->attributes = $request->getPost('SolicitudFindUserForm');
         if ($form->validate()) {
            $persona = $this->findPersona($form);
            if ($persona != null) {
               if ($titular->dni == $persona->dni) {
                  http_response_code(400);
                  $form->addError("general", "El titular no debe agregarse a si mismo");
               } elseif (!is_null($persona->grupo_conviviente_id)) {
                  if (Yii::app()->user->getState(self::$SOLICITUD_KEY)->grupoConviviente->domicilio->id == $persona->domicilio->id) {
                     header('Content-type: application/json');
                     echo CJSON::encode($persona);
                     Yii::app()->end();
                  } else {
                     http_response_code(400);
                     $calle = $persona->domicilio->calle;
                     $form->addError("general", "$persona->nombre $persona->apellido figura en domicilio de la calle $calle. Debe desvincularlo de este domicilio para agregarlo a este grupo conviviente. Puede modificar la solicitud mas tarde.");
                  }
               } else {
                  header('Content-type: application/json');
                  echo CJSON::encode($persona);
                  Yii::app()->end();
               }
            } else {
               $this->redirect("_altaPersona");
            }
         } else {
            http_response_code(400);
         }
      }
      $this->renderPartial('new', array('model'=> $form));
   }

   /**
   */
   public function action_altaPersona() {
      $request = Yii::app()->request;
      $form = new PersonaForm("new");

      if($request->isPostRequest) {
         $form->attributes = $request->getPost('PersonaForm');
         if($form->validate()) {
            header('Content-type: application/json');
            echo CJSON::encode(PersonaManager::savePersona($form));
            Yii::app()->end();
         } else {
            http_response_code(400);
         }
      }

      $this->renderPartial('altaPersona', array('model'=>$form));
   }


   /**
    */
   public function getServicios() {
      return CHtml::listData(TipoServicio::model()->findAll(), 'id', 'descripcion');
   }

   /**
    * Busca persona para un formulario valido
    */
   private function findPersona($form) {
      if (empty($form->dni)) {
         $q = new CDbCriteria();
         $q->addColumnCondition(
            array('LOWER(nombre)'=>strtolower($form->nombre),
                  'LOWER(apellido)'=> strtolower($form->apellido)));
         return Persona::model()->find($q);
      } else {
         return Persona::model()->findByAttributes(array("dni" => $form->dni));
      }
   }

   /**
    * Devuelve el titular en session. Si no esta, vuelve al punto cero con un mensaje de error.
    */
   private function getTitularInSession() {
      $titular = Yii::app()->user->getState(self::$PERSONA_KEY);
      if ($titular == null) {
         Yii::app()->user->setFlash('sessionError', "No se encuentran datos del titular solicitante en sesion. Comience el proceso nuevamente.");
         $this->redirect('new');
      }

      return $titular;
   }

   /**
    */
   private function canUpdateDomicilio($baseForm, $model) {
      $found = $this->findDomicilio($baseForm);

      return is_null($found) || ($found->id == $model->domicilio->id);
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
            'LOWER(lote)' => strtolower($baseForm->lote),
      ));

      return Domicilio::model()->find($q);
   }

   /**
    */
   private function populateGrupoConvivienteForm($form, $solicitud) {
      if(!is_null($solicitud->domicilio->viviendaActual)) {
         $form->servicios =  array_map( function($el) { return ((array)$el->attributes); },
                                        $solicitud->domicilio->viviendaActual->servicios );
         $form->banios =  array_map( function($el) { return ((array)$el->attributes); },
                                        $solicitud->domicilio->viviendaActual->banios );
         $form->observaciones = $solicitud->domicilio->viviendaActual->observaciones;
      }

      $convivientes = array();
      $vinculos = array_map(function($el){return $el->attributes;}, $solicitud->titular->vinculos);
      foreach ($solicitud->grupoConviviente->personas as $key => $value) {
         if($value->dni == $solicitud->titular->dni) continue;
         $unConviviente = array();
         $unConviviente['dni'] = $value->dni;
         $unConviviente['nombre'] = $value->nombre;
         $unConviviente['apellido'] = $value->apellido;
         $unConviviente['sexo'] = $value->sexo;

         $unConviviente["solicitante"] = !is_null($value->solicitud_id) && $value->solicitud_id == $solicitud->id? 1 : 0;
         $unConviviente["cotitular"] = !is_null($solicitud->cotitular) && $value->dni == $solicitud->cotitular->dni ? 1 : 0;
         $index = array_search($value->id, array_column($vinculos, 'familiar_id'));
         if (is_integer($index)) {
            if($value->sexo == 'M') {
               $unConviviente["vinculo"] = VinculosUtil::getVinculoMasculinoRetrogrado($vinculos[$index]['vinculo']);
            } else {
               $unConviviente["vinculo"] = VinculosUtil::getVinculoFemeninoRetrogrado($vinculos[$index]['vinculo']);
            }
         } else {
            $unConviviente["vinculo"] = "Sin vinculo";
         }

         array_push($convivientes, $unConviviente);
      }

      $form->convivientes = $convivientes;
   }
}
?>