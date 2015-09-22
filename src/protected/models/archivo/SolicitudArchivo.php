<?php
class SolicitudArchivo extends CActiveRecord {
   public $estado_search;
   
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
               'comparte_dormitorio, condicion_alquiler_id, titular_id, cotitular_id,'.
               'domicilio_id, observaciones_vivienda, tipo_resolucion_id, comentarios, estado_search', 'safe')
      );
   }

   /**
    * @return array relational rules.
    */
   public function relations() {
      return array(
         'domicilio' => array(self::BELONGS_TO, 'Domicilio', 'domicilio_id'),
         'titular' => array(self::BELONGS_TO, 'Persona', 'titular_id'),
         'cotitular' => array(self::BELONGS_TO, 'Persona', 'cotitular_id'),
         'tipoSolicitud' => array(self::BELONGS_TO, 'TipoSolicitud', 'tipo_solicitud_id'),
         'condicionUso' => array(self::BELONGS_TO, 'CondicionUso', 'condicion_uso_id'),
         'condicionAlquiler' => array(self::BELONGS_TO, 'CondicionAlquiler', 'condicion_alquiler_id'),
         'condicionLote' => array(self::BELONGS_TO, 'CondicionLote', 'condicion_lote_id'),
         
         'convivientes' => array(self::HAS_MANY, 'ConvivienteArchivo', 'solicitud_archivo_id'),
         'tipoVivienda' => array(self::BELONGS_TO, 'TipoVivienda', 'tipo_vivienda_id'),
         'resolucion' => array(self::BELONGS_TO, 'TipoResolucion', 'tipo_resolucion_id'),
         'banios' => array(self::HAS_MANY, 'BanioArchivo', 'solicitud_archivo_id'),
         'servicios' => array(self::HAS_MANY, 'ServicioArchivo', 'solicitud_archivo_id'),
      );
   }

   public function search() {

      $criteria=new CDbCriteria;
      $criteria->with = array('resolucion');
      $criteria->compare('numero',$this->numero, true);
      $criteria->compare('fecha',$this->fecha, true);
      $criteria->compare('LOWER(resolucion.descripcion)',$this->estado_search, true, 'OR');


      return new CActiveDataProvider($this, array(
         'criteria'=>$criteria,
      ));
   }

}
