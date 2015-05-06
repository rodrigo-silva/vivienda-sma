<?php 
class FiltroForm extends CFormModel {
   public $condiciones;
   public $adulto;
   public $menor;

   public function rules() {
     return array(
         array('condiciones,adulto,menor', 'safe'),

      );
   }
                   
   public function attributeLabels() {
      return array(
         'condiciones' => 'Condiciones especiales',
         'adulto' => 'Adulto Mayor',
         'menor' => 'Menor de 18',
      );
   }
}