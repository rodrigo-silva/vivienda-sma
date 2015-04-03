<?php
class Servicio extends CActiveRecord {
   
   public function tableName() {
      return 'servicio';
   }

   public static function model($className=__CLASS__) {
      return parent::model($className);
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      
      return array();
   }

   /**
    * @return array relational rules.
    */
   public function relations() {
      return array();
   }

}
