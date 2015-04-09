<?php
class SolicitudArchivo extends CActiveRecord {
   
   public function tableName() {
      return 'solicitud_archivo';
   }

   public static function model($className=__CLASS__) {
      return parent::model($className);
   }

   public function init() {
      $this->estado_administrativo_solicitud_id = EstadoAdministrativoSolicitud::model()->findByAttributes(array('nombre'=>'Archivada'))->id;
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      
      return array(
         array('numero, fecha, tipo_solicitud_id, tipo_vivienda_id, condicion_lote_id, condicion_uso_id,'.
               'condicion_alquiler_id, titular_id, cotitular_id,'.
               'domicilio_id, observaciones_vivienda, tipo_resolucion_id, comentarios', 'safe')
      );
   }

   /**
    * @return array relational rules.
    */
   public function relations() {
      return array();
   }

}
