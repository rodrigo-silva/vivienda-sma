<?php
class Event extends CActiveRecord {
   
   public function tableName() {
      return 'event';
   }

   public static function model($className=__CLASS__) {
      return parent::model($className);
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      
      return array(
         array('username,fecha,numero_solicitud,detalle', 'required')
      );
   }

   /**
    * @return array relational rules.
    */
   public function relations() {
      return array();
   }

}
