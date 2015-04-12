<?php
class UserController extends Controller {

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
            'actions'=>array('changePassword', 'myAccount'),
            'users'=>array('@')
         ),
         array('allow',
            'actions'=>array('admin', 'create', 'resetPassword', 'delete', 'update'),
            'roles'=>array('admin')
         ),
         array('deny',  // deny all users
            'users'=>array('*'),
         ),
      );
   }
   
   public function actionAdmin() {
      $model=new User();
      $model->unsetAttributes();  // clear any default values
      if(isset($_GET['User']))
         $model->attributes=$_GET['User'];
      
      $this->render('admin',array('model'=>$model,));
   }

   public function actionCreate() {
      $model = new CreateUserForm;
      $request = Yii::app()->request;

      if($request->isPostRequest) {
         $model->attributes = $request->getPost('CreateUserForm');
         if( $model->validate() ) {
            $user = new User;
            $user->attributes = $model->attributes;
            $user->username = $model->username;
            $user->password = CPasswordHelper::hashPassword($model->create_password);
            if( $user->save() ) {
               Yii::app()->user->setFlash('general-success', 'Usuario creado exitosamente.');
            } else {
               Yii::app()->user->setFlash('general-error', 'Ocurrio un error al salvar el usuario. Intentelo mas tarde.');
            }
            $this->redirect('/user/admin');
         }
      }

      $this->render('create', array('model'=>$model));
   }

   public function actionUpdate($id) {
      $request = Yii::app()->request;
      $user = User::model()->findByPk($id);
      $model = new UpdateUserForm;
      $model->attributes = $user->attributes;
      if($request->isPostRequest) {
         $model->attributes = $request->getPost('UpdateUserForm');
         if( $model->validate() ) {
            $user->attributes = $model->attributes;
            if( $user->save() ) {
               Yii::app()->user->setFlash('general-success', 'Usuario actualizado exitosamente.');
            } else {
               Yii::app()->user->setFlash('general-error', 'Ocurrio un error al salvar el usuario. Intentelo mas tarde.');
            }
            $this->redirect('/user/admin');
         }
      }

      $this->render('update', array('model'=>$model));
   }

   /**
    */
   public function actionDelete($id) {
      $usuario = User::model()->findByPk($id);
      if (!is_null($usuario)) {
         if( $usuario->id != Yii::app()->user->id ) {
            $usuario->delete();
         } else {
            http_response_code(400);
            header('Content-type: application/json');
            echo CJSON::encode(array('error'=>"No puede borrarse a si mismo."));
            Yii::app()->end();
         }
      } else {
         http_response_code(400);
         header('Content-type: application/json');
         echo CJSON::encode(array('error'=>"El usuario no existe."));
         Yii::app()->end();
      }
   }

   /**
    */
   public function actionChangePassword() {
      $model = new ChangePasswordForm;
      $request = Yii::app()->request;

      if($request->isPostRequest) {
         $model->attributes = $request->getPost('ChangePasswordForm');
         if( $model->validate() ) {
            $user = User::model()->findByPk(Yii::app()->user->id);
            if( is_null($user) ) {
               Yii::app()->user->setFlash('general-error', 'El usuarion no existe en la base.');
               $this->redirect('/user/admin');
            } else {
               if( CPasswordHelper::verifyPassword($model->change_oldPassword, $user->password) ) {
                  $user->password = CPasswordHelper::hashPassword($model->change_password);
                  if( $user->save() ) {
                     Yii::app()->user->setFlash('general-success', 'Password actualizado exitosamente.');
                  } else {
                     Yii::app()->user->setFlash('general-error', 'Ocurrio un error al salvar el password');
                  }
                  $this->redirect('/user/admin');
               } else {
                  Yii::app()->user->setFlash('general-error', 'La contrase&ntilde;a anterior es incorrecta');
               }
            }
         }
      }

      $this->render('changePassword', array('model'=>$model));
   }

   public function actionResetPassword($id) {
      $model = new ResetPasswordForm;
      $request = Yii::app()->request;

      if($request->isPostRequest) {
         $model->attributes = $request->getPost('ResetPasswordForm');
         if( $model->validate() ) {
            $user = User::model()->findByPk($id);
            if( is_null($user) ) {
               Yii::app()->user->setFlash('general-error', 'El usuarion no existe en la base.');
               $this->redirect('/user/admin');
            } else {
               $user->password = CPasswordHelper::hashPassword($model->reset_password);
               if( $user->save() ) {
                  Yii::app()->user->setFlash('general-success', 'Password actualizado exitosamente.');
               } else {
                  Yii::app()->user->setFlash('general-error', 'Ocurrio un error al salvar el password');
               }
               $this->redirect('/user/admin');
            }
         }
      }

      $this->render('resetPassword', array('model'=>$model));
   }

}
?>