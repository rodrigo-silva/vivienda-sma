<?php

   /**
    * Formulario pre solicitud, para buscar la Persona titular
    */
   class SolicitudFindUserForm extends CFormModel {
      public $dni;
      public $nombre;
      public $apellido;

      /**
       * Reglas de validacion general
       */
      public function rules() {
         return array(
            array('dni', 'numerical', 'integerOnly'=>true, 'allowEmpty'=>true, 'message'=>'Utilice numeros sin puntos'),
            array('dni, nombre, apellido', 'safe')
         );
      }

      /**
       */
      public function attributeLabels() {
         return array(
            'dni' => 'D.N.I.',
            'nombre' => 'Nombre/s',
            'apellido' => 'Apellido/s'
         );
      }

   }

?>