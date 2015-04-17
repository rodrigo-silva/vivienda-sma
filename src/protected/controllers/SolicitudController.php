<?php

class SolicitudController extends Controller {

   /**
    * @Override
    */
   public function init() {
      $this->defaultAction = 'admin';
      parent::init();
   }

   /**
    * @return array action filters
    */
   public function filters() {
      return array(
         'accessControl', // perform access control for CRUD operations
         'postOnly + delete', // we only allow deletion via POST request
      );
   }

   /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
   public function accessRules()
   {
      return array(
         array('allow',
            'actions'=>array('admin','view', 'print'),
            'roles'=>array('reader', 'writer')
         ),
         array('allow',
            'actions'=>array('new', 'altaPersona', 'solicitudBase', 'grupoExistente',
                             'confeccionGrupoConviviente', 'update', 'archivar', '_getConviviente', '_altaPersona'),
            'roles'=>array('writer')
         ),
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }

   public function actionAdmin() {
      $model=new Solicitud();
      $model->unsetAttributes();  // clear any default values
      if(isset($_GET['Solicitud']))
         $model->attributes=$_GET['Solicitud'];
      
      $this->render('admin',array('model'=>$model,));
   }

   /**
    */
   public function actionView($id) {
      $solicitud = Solicitud::model()->with(
         array('domicilio', 'domicilio.viviendaActual.servicios', 'domicilio.viviendaActual.banios',
               'condicionUso'))->findByPk($id);
      if($solicitud===null) {
         throw new CHttpException(404,'Esta intentando actualizar una Solicitud inexistente en el sistema');
      }
      $this->render('view', array('model'=>$solicitud));
   }

   public function actionPrint($id) {
      $this->layout = 'print';
      $solicitud = Solicitud::model()->with(
         array('domicilio', 'domicilio.viviendaActual.servicios', 'domicilio.viviendaActual.banios',
               'condicionUso'))->findByPk($id);
      if($solicitud===null) {
         throw new CHttpException(404,'Esta intentando actualizar una Solicitud inexistente en el sistema');
      }
      $this->render('print', array('model'=>$solicitud));
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
                  if($persona->grupo_conviviente_id == null) {
                     $this->redirect(array("solicitudBase", "for"=>"p:$persona->id"));
                  } else {
                     $this->redirect(array('grupoExistente', "for"=>"p:$persona->id", 'at'=>sprintf("d:%d", $persona->domicilio->id)));
                  }
               } else {
                  Yii::app()->user->setFlash('warning', "$persona->nombre $persona->apellido figura vinculado/a a la ". 
                        "solicitud numero ". $persona->solicitud->numero. ". Debe desvincularse para generar una solicitud en su nombre." );
               }
            } else {
               Yii::app()->user->setFlash('general-info', "La persona no se encuentra en el sistema. " . 
                     "Debe darla de alta para continuar.");
               $this->redirect("altaPersona");
            }
         }
      } else {
         Yii::app()->user->setFlash('general-info', "Primero debe buscar en sistema a quien sera el titular");
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
            $persona = PersonaManager::savePersona($form);
            Yii::app()->user->setFlash('general-success', "Se ha dado de alta a $persona->nombre $persona->apellido exitosamente.");
            $this->redirect(array("solicitudBase", "for"=>"p:$persona->id"));
         }
      }
      $this->render('altaPersona', array('model'=>$form));
   }

   /**
    */
   public function actionSolicitudBase() {
      $titular = $this->getTitularInRequest();

      $request = Yii::app()->request;
      $form = new SolicitudBaseForm('post');
      if($request->isPostRequest) {
         $form->attributes = $request->getPost('SolicitudBaseForm');
         if($form->validate()) {
            $domicilio = $this->findDomicilio($form);
            if(is_null($domicilio)) {
               $solicitud = SolicitudManager::saveSolicitudBase($form, $titular);
               $this->redirect(array('confeccionGrupoConviviente', 'use'=>"s:$solicitud->id"));  
            } else {
               $this->redirect(array('grupoExistente', "for"=>"p:$titular->id", 'at'=>"d:$domicilio->id"));
            }
         }
      }
      
      $this->render('solicitudBase', array('model'=>$form, 'titular'=>$titular));        
   }

   /**
    */
   public function actionGrupoExistente() {
      $titular = $this->getTitularInRequest();
      $domicilio = $this->getDomicilioInRequest();
      
      $request = Yii::app()->request;
      if($request->isPostRequest) {
         if($request->getPost('desvincular')) {
            $titular->grupo_conviviente_id = NULL;
            $titular->save();
            $this->redirect(array("solicitudBase", "for"=>"p:$titular->id"));
         } else {
            $form = new SolicitudBaseForm('post');
            $form->attributes = $domicilio->attributes;
            $form->tipo_vivienda_id = 1;
            $form->tipo_solicitud_id = 1;
            $form->condicion_lote_id = 1;
            $form->condicion_uso_id = 1;
            $form->es_alquiler = 0;
            $solicitud = SolicitudManager::saveSolicitudBase($form, $titular);
            $this->redirect('/solicitud/update/' . $solicitud->id);
         }
      }

      $this->render("grupoExistente", array("titular" => $titular, 'domicilio' => $domicilio));
   }

   /**
    */
   public function actionConfeccionGrupoConviviente() {
      $request = Yii::app()->request;
      $solicitud = $this->getSolicitudInRequest();
      $form = new ConfeccionGrupoConvivienteForm;
      
      if ($request->isPostRequest) {
         $form->attributes = $request->getPost("ConfeccionGrupoConvivienteForm");
         SolicitudManager::saveGrupoConvivienteInfo($form, $solicitud);
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
    *
    */
   public function actionUpdate($id) {
      $solicitud = Solicitud::model()->with(
         array('domicilio', 'domicilio.viviendaActual.servicios', 'domicilio.viviendaActual.banios',
               'condicionUso', 'titular'))->findByPk($id);
      if($solicitud===null) {
         throw new CHttpException(404,'Esta intentando actualizar una Solicitud inexistente en el sistema');
      }

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
            $this->redirect('/solicitud/admin');
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
               'solicitud' => $solicitud,
               'titular' => $solicitud->titular
         )
      );

   }

   /**
    */
   public function action_getConviviente() {
      $request = Yii::app()->request;
      $form = new SolicitudFindUserForm;
      
      if ($request->isPostRequest) {
         $form->attributes = $request->getPost('SolicitudFindUserForm');
         if ($form->validate()) {
            $persona = $this->findPersona($form);
            if ($persona != null) {
               $currentSolicitud = $this->getSolicitudInRequest();
               if ($currentSolicitud->titular->dni == $persona->dni) {
                  http_response_code(400);
                  $form->addError("general", "El titular no debe agregarse a si mismo");
               } elseif (!is_null($persona->solicitud_id)){
                  Yii::app()->user->setFlash('warning', "$persona->nombre $persona->apellido figura vinculado/a a la solicitud numero ". $persona->solicitud->numero. ". Debe desvincularse para agregarse aqui." );
               } elseif (!is_null($persona->grupo_conviviente_id)) {
                  if ($currentSolicitud->grupoConviviente->domicilio->id == $persona->domicilio->id) {
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
   public function actionArchivar($id) {
      $request = Yii::app()->request;
      $model = new ArchivarForm;
      $model->numero = $id;
      
      if($request->isPostRequest) {
         $model->attributes = $request->getPost('ArchivarForm');
         if($model->validate()) {
            SolicitudManager::archivarSolicitud($model);
            $this->redirect("/solicitud/admin");
         }
      }

      $this->render("archivar", array('model'=>$model));
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
    * Devuelve el titular en el request. Si no esta, 400 :)
    */
   private function getTitularInRequest() {
      $request = Yii::app()->request;
      $id = explode(":", $request->getQuery('for'));

      $titular = Persona::model()->findByPk($id);
      if ($titular == null) {
         $url = $request->getUrl();
         Yii::log("Se intento acceder a $url y no se encontro la persona", 'warning', 'com.wazoo.controller');
         throw new CHttpException(400, 'La peticion no es correcta.');
      }
      Yii::trace("Titular $titular->id", 'com.wazoo.controller');

      return $titular;
   }

   /**
    * Devuelve la solicitud en el request. Si no esta, 400 :)
    */
   private function getSolicitudInRequest() {
      $request = Yii::app()->request;
      $id = explode(":", $request->getQuery('use'));

      $solicitud = Solicitud::model()->findByPk($id);
      if ($solicitud == null) {
         $url = $request->getUrl();
         Yii::log("Se intento acceder a $url y no se encontro la solicitud", 'warning', 'com.wazoo.controller');
         throw new CHttpException(400, 'La peticion no es correcta.');
      }
      Yii::trace("Solicitud $solicitud->id", 'com.wazoo.controller');

      return $solicitud;
   }

   /**
    * Devuelve el domicilio en el request. Si no esta, 400 :)
    */
   private function getDomicilioInRequest() {
      $request = Yii::app()->request;
      $id = explode(":", $request->getQuery('at'));

      $domicilio = Domicilio::model()->findByPk($id);
      if ($domicilio == null) {
         $url = $request->getUrl();
         Yii::log("Se intento acceder a $url y no se encontro el domicilio", 'warning', 'com.wazoo.controller');
         throw new CHttpException(400, 'La peticion no es correcta.');
      }
      Yii::trace("Domicilio $domicilio->id", 'com.wazoo.controller');

      return $domicilio;
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

         if(is_null($value->solicitud_id)) {
            $unConviviente["solicitante"] =  0;
            $unConviviente["solicitante_foraneo"] = !is_null($value->cotitularidad) &&  $value->cotitularidad->id != $solicitud->id ? 1: 0;
         } else {
            $unConviviente["solicitante"] = $value->solicitud_id == $solicitud->id? 1 : 0;
            $unConviviente["solicitante_foraneo"] = $value->solicitud_id != $solicitud->id? 1 : 0;
         }

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