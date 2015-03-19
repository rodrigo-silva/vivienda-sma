<?php
class SituacionEconomica extends CActiveRecord {
   
   public function tableName() {
      return 'situacion_economica';
   }

   public static function model(=__CLASS__) {
      return parent::model();
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      return array(
         array( 'ingresos_laborales, ingresos_alimentos, ingresos_subsidio', 'numerical', 'integerOnly'=>true )
      );
   }

   /**
    * @return array relational rules.
    */
   public function relations() {
      return array(
         'situacionLaboral' => array(self::HAS_ONE, 'SituacionLaboral', 'situacion_economica_id'),
         'persona' => array(self::BELONGS_TO, 'Persona', 'persona_id'),
      );
   }

}
