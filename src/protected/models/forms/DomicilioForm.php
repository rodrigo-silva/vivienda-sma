<?php
class DomicilioForm extends CFormModel {
   public $calle;
   public $altura;
   public $piso;
   public $departamento;
   public $casa;
   public $lote;
   public $observaciones;
   
   /**
    */
   public function rules() {
      return array(
         array('calle', 'required', 'message'=>'Campo obligatorio'),
         array('altura', 'required', 'message'=>'Ingrese una indicacion de altura cualquiera'),
         array('calle, altura, piso, departamento, casa, lote, observaciones', 'safe'),
         array('calle, altura, piso, departamento, casa, lote', 'safe', 'on'=>'findSame'),
      );
   }

   public function attributeLabels() {
      array(
         'calle' => 'Nombre calle o ruta',
         'altura' => 'Altura, Km de ruta u otra indicacion.',
         'piso' => 'Piso',
         'departamento' => 'Departamento',
         'casa' => 'Numero de casa o puerta',
         'lote' => 'Numero de lote',
         'observaciones' => 'Observaciones generales',
      );
   }
}