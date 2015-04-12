<?php
class CreateUserForm extends CFormModel {
   public $username;
   public $nombre;
   public $apellido;
   public $create_password;
   public $create_repassword;
   public $role;

   public function rules() {
     return array(
         array('username, nombre, apellido, create_password, create_repassword, role', 'required'),
         array('nombre, apellido', 'length', 'max'=> 40),
         array('username', 'length', 'max'=> 20),
         array('username', 'unique', 'className' => 'User', 'attributeName' => 'username',
               'message' => 'Ya existe un usuario con ese nombre'),
         array('create_password', 'length', 'min'=> 8),
         array('create_password', 'compare', 'compareAttribute' => 'create_repassword', 'message'=>'Las contrase&ntilde;as no coinciden'),

      );
   }
                   
   public function attributeLabels() {
      return array(
         'username'=> 'Nombre de usuario',
         'nombre'=> 'Nombre',
         'apellido'=> 'Apellido',
         'create_password'=> 'Password',
         'create_repassword'=> 'Confirmar',
         'role'=> 'Rol',
      );
   }
}