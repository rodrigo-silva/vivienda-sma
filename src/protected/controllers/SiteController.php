<?php

class SiteController extends Controller {

   

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}


	/**
	 * Displays the login page
	 */
	public function actionLogin() {
      $this->layout='login';  
      $form = new LoginForm;
      $request = Yii::app()->request;

      if( $request->isPostRequest ) {
         $form->attributes = $request->getPost('LoginForm');
         if( $form->validate() ) {
            $identity = new UserIdentity($form->username, $form->login_password);
            if($identity->authenticate()) {
                Yii::app()->user->login($identity);
                Yii::app()->request->redirect(Yii::app()->user->returnUrl);
            } else {
               Yii::app()->user->setFlash('loginError', 'Usuario o Contrase&ntilde;a invalidas. Intente nuevamente.');
            }
         }
      }

      $form->unsetAttributes();
      $this->render('login', array('model'=>$form));
		
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->user->loginUrl);
	}
}