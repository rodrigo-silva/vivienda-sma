<?php
class SolicitudArchivoController extends Controller {
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
            'actions'=>array('admin','view'),
            'roles'=>array('reader', 'writer')
         ),
         array('allow',
            'actions'=>array('update'),
            'roles'=>array('writer')
         ),
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }

   public function actionAdmin() {
      $model=new SolicitudArchivo();
      $model->unsetAttributes();  // clear any default values
      if(isset($_GET['SolicitudArchivo']))
         $model->attributes=$_GET['SolicitudArchivo'];
      
      $this->render('admin',array('model'=>$model,));
   }

   public function actionView($id) {
      $solicitud = SolicitudArchivo::model()->with(
         array('domicilio', 'domicilio.viviendaActual.servicios', 'domicilio.viviendaActual.banios',
               'condicionUso'))->findByPk($id);
      if($solicitud===null) {
         throw new CHttpException(404,'Esta intentando actualizar una Solicitud inexistente en el sistema');
      }
      $eventos=Event::model()->findAllByAttributes( array('numero_solicitud'=>$solicitud->numero) );

      $this->render('view', array('model'=>$solicitud, 'eventos'=>$eventos));
   }

   public function actionUpdate($id) {
      $solicitud = SolicitudArchivo::model()->findByPk($id);
      if($solicitud===null) {
         throw new CHttpException(404,'Esta intentando actualizar una Solicitud inexistente en el sistema');
      }

      $request = Yii::app()->request;
      $form = new ArchivarForm;
      if($request->isPostRequest) {
         $form->attributes = $request->getPost('ArchivarForm');
         if($form->validate()) {
            $solicitud->comentarios = $form->comentarios;
            $solicitud->tipo_resolucion_id = $form->tipo_resolucion_id;
            
            $solicitud->save();

            $this->redirect( Yii::app()->createUrl("solicitudArchivo") );
         }
      } else {
         $form->comentarios = $solicitud->comentarios;
         $form->tipo_resolucion_id = $solicitud->tipo_resolucion_id;
         $form->numero = $solicitud->numero;
      }

      $this->render('edit', array('model'=>$form));
   }
}