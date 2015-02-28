<?php

class SolicitudController extends Controller {

   private static $PERSONA_KEY = 'persona-solicitud';
   private static $DOMICILIO_KEY = 'domicilio-solicitud';

   /**
    * Punto de entrada para crear una solicitud. Busca la Persona para asociar como titular. Si no existe redirecciona a crearla
    */
   public function actionNew() {
      $request = Yii::app()->request;
      $form = new SolicitudFindUserForm;
      
      if ($request->isPostRequest) {
         $form->attributes = $request->getPost('SolicitudFindUserForm');
         if ($form->validate() && $this->validateSolicitudFindUserForm($form)) {
            $persona = Persona::model()->findByAttributes($form->getAttributes());
            if ($persona != null) {
               Yii::app()->user->setState(self::$PERSONA_KEY, $persona);
               $this->redirect("buildSolicitud");
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
            $this->redirect('domicilio');
         }
      }
      $this->render('altaPersona', array('model'=>$form));
   }

   /**
    */
   public function actionDomicilio() {
      $request = Yii::app()->request;
      $form = new DomicilioForm;

      if($request->isPostRequest) {
         $form->attributes = $request->getPost('DomicilioForm');
         if($form->validate()) {
            $searchForm = new DomicilioForm('findSame');
            $searchForm->attributes = $request->getPost('DomicilioForm');
            $domicilio = Domicilio::model()->with('grupoConviviente')->findByAttributes($searchForm->attributes);
            if($domicilio == null) {
               $domicilio = DomicilioManager::createDomicilio($form);
            }
            Yii::app()->user->setState(self::$DOMICILIO_KEY, $domicilio);
         }
      }

      $this->render('domicilio', array('model'=>$form));        
   }

   /**
    */
   public function actionBuildSolicitud() {
      $titular = Yii::app()->user->getState(self::$PERSONA_KEY);
      if ($titular == null) {
         Yii::app()->user->setFlash('sessionError', "Se perdieron los datos de la persona solicitante durante la sesion." .
                                                     "Por favor intente nuevamente");
         $this->redirect('new');
      }

      $request = Yii::app()->request;
      if($request->isPostRequest) {

      }
      

   }

   /**
    * Valida la prescencia exclusiva de los campos del form de entrada/busqueda.
    */
   private function validateSolicitudFindUserForm($form) {
      if ($form->dni == null) {
         if ($form->nombre == null && $form->apellido == null) {
            $form->addError("general", "Debe especificar o bien DNI o Nombre y Apellido");
            return false;
         } else {
            return true;
         }
      } else {
         return true;
      }
   }
}
?>