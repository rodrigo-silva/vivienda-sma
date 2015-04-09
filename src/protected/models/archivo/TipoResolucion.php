<?php
   class TipoResolucion extends CActiveRecord {
      
      public function tableName() {
         return 'tipo_resolucion';
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
