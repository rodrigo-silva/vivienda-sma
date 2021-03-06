<?php
class Vinculo extends CActiveRecord {
   
   public function tableName() {
      return 'vinculo';
   }

   public static function model($className=__CLASS__) {
      return parent::model($className);
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      
      return array(
         array('persona_id, tipo, familiar_id', 'required')
      );
   }

   /**
    * @return array relational rules.
    */
   public function relations() {
      return array(
         'con' => array(self::BELONGS_TO, 'Vinculo', 'familiar_id')
      );
   }
}
