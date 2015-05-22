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

      /**
       */
      public function validate($attributes=null, $clearErrors=true) {
         if(parent::validate()) {
            return $this->validateFieldPrescenceCombination();
         } else {
            return false;
         }
      }

      /**
       * Valida la prescencia exclusiva de los campos del form de entrada/busqueda.
       */
      private function validateFieldPrescenceCombination() {
         if ($this->dni == null) {
            if ($this->nombre == null || $this->apellido == null) {
               $this->addError("general", "Debe especificar o bien DNI o Nombre y Apellido");
               return false;
            } else {
               return true;
            }
         } else {
            return true;
         }
      }

   }

?>