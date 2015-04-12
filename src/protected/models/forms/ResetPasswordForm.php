<?php 
class ResetPasswordForm extends CFormModel {
   public $reset_password;
   public $reset_repassword;

   public function rules() {
     return array(
         array('reset_password, reset_repassword', 'required'),
         array('reset_password', 'length', 'min'=> 8),
         array('reset_password', 'compare', 'compareAttribute' => 'reset_repassword', 'message'=>'Las contrase&ntilde;as no coinciden'),

      );
   }
                   
   public function attributeLabels() {
      return array(
         'reset_password'=> 'Nuevo Password',
         'reset_repassword'=> 'Confirmar',
      );
   }
}