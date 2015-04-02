<?php

class SolicitudController extends Controller {

   private static $PERSONA_KEY = 'persona-solicitud';
   private static $DOMICILIO_KEY = 'domicilio-solicitud';
   private static $SOLICITUD_KEY = 'solicitud';

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
      $form = new PersonaForm;
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
            $this->redirect('confeccionGrupoConviviente');  
         }
      }
      $this->render('solicitudBase', array('model'=>$form));        
   }

   /**
    */
   public function actionConfeccionGrupoConviviente() {
      $titular = $this->getTitularInSession();
      $vinculosMasculinos = VinculosUtil::getVinculosMasculinos(); 
      $vinculosFemeninos = VinculosUtil::getVinculosFemeninos(); 
      $vinculosMasculinos = array_combine($vinculosMasculinos, $vinculosMasculinos);
      $vinculosFemeninos = array_combine($vinculosFemeninos, $vinculosFemeninos);
     
      $this->render('confeccionGrupoConviviente',
         array('findPersonaForm'=> new SolicitudFindUserForm,
               'vinculosFemeninosList' => $vinculosFemeninos,
               'vinculosMasculinosList' => $vinculosMasculinos,
               'titular' => $titular,
               'solicitud' => Yii::app()->user->getState(self::$SOLICITUD_KEY)
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
      $form = new PersonaForm;

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
   public function actionnada() {
      $request = Yii::app()->request;
      $form = new SolicitudFindUserForm;
      $form->dni = $request->getQuery('dni');
      $form->nombre = $request->getQuery('nombre');
      $form->apellido = $request->getQuery('apellido');
      if($request->isPostRequest) {
         $response = new CMap;
         $response->copyFrom($form);
         $response->add('vinculo', $request->getPost('vinculo'));
         echo CJSON::encode($response);
         Yii::app()->end();
      }

      $this->renderPartial('vincularConviviente', array('model'=>$form));
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
}
?>