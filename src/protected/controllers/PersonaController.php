<?php

class PersonaController extends Controller
{
	
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
            'actions'=>array('admin','view'),
            'roles'=>array('reader', 'writer')
         ),
         array('allow',
				'actions'=>array('create', 'update', 'delete'),
            'roles'=>array('writer')
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
      $model=Persona::model()->with(array('situacionEconomica', 'condicionesEspeciales', 'domicilio', 'solicitud'))->findByPk($id);
      if($model===null)
         throw new CHttpException(404,'La persona no se encuentra en el sistema.');

		$this->render('view',array('model'=>$model));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$request = Yii::app()->request;
      $form = new PersonaForm("new");
      if($request->isPostRequest) {
         $form->attributes = $request->getPost('PersonaForm');
         if($form->validate()) {
            PersonaManager::savePersona($form);
            Yii::app()->user->setFlash('general-success', "$form->nombre $form->apellido ha sido creado.");
            $this->redirect('admin');
         }
      }
      $this->render('create', array('model'=>$form));
   }

   /**
    * Updates a particular model.
    * If update is successful, the browser will be redirected to the 'admin' page.
    * @param integer $id the ID of the model to be updated
    */
   public function actionUpdate($id) {
      $model=Persona::model()->with(
         array('condicionesEspeciales', 'situacionEconomica', 'situacionEconomica.situacionLaboral'))->findByPk($id);
      if($model===null)
         throw new CHttpException(404,'Esta intentando actualizar una Persona inexistente en el sistema');

      $request = Yii::app()->request;
      if($request->isPostRequest) {
         $form = $model->dni != $request->getPost('PersonaForm')['dni'] ? new PersonaForm('dniUpdate') : new PersonaForm;
         $form->attributes = $request->getPost('PersonaForm');
         $form->persona_id = $model->id;
         $form->id = $model->id;
         if($form->validate()) {
            PersonaManager::savePersona($form);
            Yii::app()->user->setFlash('general-success', "$form->nombre $form->apellido ha sido actualizado.");
            $this->redirect(Yii::app()->createUrl("persona/view") . '/' . $id);
         }
      } else {
         $form = new PersonaForm;
         $form->attributes = $model->attributes;
         $form->attributes = $model->situacionEconomica->attributes;
         $form->attributes = $model->situacionEconomica->situacionLaboral->attributes;
         $form->condicionesEspeciales = array_map(function($e){return $e->id;}, $model->condicionesEspeciales);
      }

      $this->render('update', array('model'=>$form));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
      $persona = Persona::model()->with(array('titularidad', 'cotitularidad'))->findByPk($id);
      if (is_null($persona->titularidad) && is_null($persona->cotitularidad)) {
         $persona->delete();
      } else {
         http_response_code(400);
         header('Content-type: application/json');
         echo CJSON::encode(array('error'=>"No se puede eliminar la persona $persona->nombre $persona->apellido por estar vinculada a solicitudes."));
         Yii::app()->end();
      }
	}

	
	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model=new Persona();
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Persona']))
			$model->attributes=$_GET['Persona'];
		
      $this->render('admin',array('model'=>$model,));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Persona the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Persona::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
