<?php 
class TipoSituacionLaboral extends CActiveRecord {
   
   public function tableName() {
      return 'tipo_situacion_laboral';
   }

   public static function model($className=__CLASS__) {
      return parent::model($className);
   }

}

