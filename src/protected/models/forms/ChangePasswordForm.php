<?php 
class ChangePasswordForm extends CFormModel {
   public $change_oldPassword;
   public $change_password;
   public $change_repassword;

   public function rules() {
     return array(
         array('change_password, change_repassword, change_oldPassword', 'required'),
         array('change_password', 'length', 'min'=> 8),
         array('change_password', 'compare', 'compareAttribute' => 'change_repassword', 'message'=>'Las contrase&ntilde;as no coinciden'),

      );
   }
                   
   public function attributeLabels() {
      return array(
         'change_password'=> 'Password',
         'change_repassword'=> 'Confirmar',
         'change_oldPassword'=> 'Password anterior',
      );
   }
}