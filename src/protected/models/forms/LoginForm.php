<?php
class LoginForm extends CFormModel {
   public $username;
   public $login_password;

   public function rules() {
      return array(
         array('username, login_password', 'required')
      );
   }

   public function attributeLabels() {
      return array(
         'username'=>'Usuario',
         'login_password'=>'Contrase&ntilde;a'
      );
   }
}