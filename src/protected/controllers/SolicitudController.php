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
      $model = Solicitud::model()->with(
         array('domicilio', 'domicilio.viviendaActual.servicios', 'domicilio.viviendaActual.banios',
               'condicionUso'))->findByPk($id);
      if($model===null)
         throw new CHttpException(404,'Esta intentando actualizar una Solicitud inexistente en el sistema');
      $request = Yii::app()->request;
      $baseForm = new SolicitudBaseForm('post');
      
      if ($request->isPostRequest) {
         if( !is_null($request->getPost('SolicitudBaseForm')) ) { //update base
            $baseForm->attributes = $request->getPost('SolicitudBaseForm');
            if($baseForm->validate()) {
               if($this->canUpdateDomicilio($baseForm, $model)) {
                  SolicitudManager::updateSolicitudBase($baseForm, $model);
               } else {
                  Yii::app()->user->setFlash('generalError', 'Los nuevos valores para el domicilio, configuran un domicilio existente en el sistema, el cual ya posee configuraciones de Grupo conviviente y detalles de la vivienda.');
               }
            }
         } else if(!is_null($request->getPost('SolicitudBaseForm'))) {

         }
      } else { //GET
         $baseForm->attributes = $model->attributes;
         $baseForm->attributes = $model->domicilio->attributes;
         if (!is_null($model->condicionAlquiler)) {
            $baseForm->attributes = $model->condicionAlquiler->attributes;
         }
      }
      $vinculosMasculinos = VinculosUtil::getVinculosMasculinos(); 
      $vinculosMasculinos = array_combine($vinculosMasculinos, $vinculosMasculinos);
      $vinculosFemeninosList = array_combine(VinculosUtil::getVinculosFemeninos(), VinculosUtil::getVinculosFemeninos());
     
      $this->render('update',
         array('baseForm' => $baseForm,
               'findPersonaForm'=> new SolicitudFindUserForm,
               'vinculosFemeninosList' => $vinculosFemeninosList,
               'vinculosMasculinosList' => $vinculosMasculinos,
               'solicitud' => $model
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
               Yii::app()->user->setState(self::$PERSONA_KEY, $persona);
               $this->redirect("solicitudBase");
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
            Yii::app()->user->setState(self::$SOLICITUD_KEY, SolicitudManager::saveSolicitudBase($form, $titular));
            Yii::app()->user->setState(self::$PERSONA_KEY, NULL);
            $this->redirect('confeccionGrupoConviviente');  
         }
      }
      $this->render('solicitudBase', array('model'=>$form));        
   }

   /**
    */
   public function actionConfeccionGrupoConviviente() {
      $request = Yii::app()->request;
      $solicitud = Yii::app()->user->getState(self::$SOLICITUD_KEY);
      
      if ($request->isPostRequest) {
         $form = new ConfeccionGrupoConvivienteForm;
         $form->attributes = $request->getPost("ConfeccionGrupoConvivienteForm");
         SolicitudManager::saveGrupoConvivienteInfo($form, $solicitud);
         Yii::app()->user->setState(self::$SOLICITUD_KEY, NULL);
      }

      $vinculosMasculinos = VinculosUtil::getVinculosMasculinos(); 
      $vinculosFemeninos = VinculosUtil::getVinculosFemeninos(); 
      $vinculosMasculinos = array_combine($vinculosMasculinos, $vinculosMasculinos);
      $vinculosFemeninos = array_combine($vinculosFemeninos, $vinculosFemeninos);
     
      $this->render('confeccionGrupoConviviente',
         array('findPersonaForm'=> new SolicitudFindUserForm,
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
      $q = new CDbCriteria();
      $q->addColumnCondition(array(
            'LOWER(calle)' => strtolower($baseForm->calle),
            'LOWER(altura)' => strtolower($baseForm->altura),
            'LOWER(piso)' => strtolower($baseForm->piso),
            'LOWER(departamento)' => strtolower($baseForm->departamento),
            'LOWER(casa)' => strtolower($baseForm->casa),
            'LOWER(lote)' => strtolower($baseForm->lote),
      ));

      $found = Domicilio::model()->find($q);

      return is_null($found) || ($found->id == $model->id);
   }  
}
?>