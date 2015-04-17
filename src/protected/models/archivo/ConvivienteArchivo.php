<?php
   class ConvivienteArchivo extends CActiveRecord {
      
      public function tableName() {
         return 'conviviente_archivo';
      }
   
      public static function model($className=__CLASS__) {
         return parent::model($className);
      }
   
      /**
       * @return array validation rules for model attributes.
       */
      public function rules() {
         
         return array(
         );
      }
   
      /**
       * @return array relational rules.
       */
      public function relations() {
         return array(
            'persona' => array(self::BELONGS_TO, 'Persona', 'persona_id'),
         );
      }
   
   }
