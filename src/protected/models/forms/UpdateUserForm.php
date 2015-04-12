<?php
class UpdateUserForm extends CFormModel {
   public $nombre;
   public $apellido;
   public $role;

   public function rules() {
     return array(
         array('nombre, apellido, role', 'required'),
         array('nombre, apellido', 'length', 'max'=> 40),
      );
   }
                   
   public function attributeLabels() {
      return array(
         'nombre'=> 'Nombre',
         'apellido'=> 'Apellido',
         'role'=> 'Rol',
      );
   }
}