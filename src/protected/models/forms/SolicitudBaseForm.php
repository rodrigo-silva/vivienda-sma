<?php
class SolicitudBaseForm extends CFormModel {
   //datos de la solicitud
   public $tipo_vivienda_id;
   public $tipo_solicitud_id;
   public $condicion_lote_id;
   public $condicion_uso_id;
   public $es_alquiler;
   public $formal = 0;
   public $costo_superior = 0;

   //Datos de domicilio
   public $calle;
   public $altura;
   public $piso;
   public $departamento;
   public $casa;
   public $lote;
   public $observaciones;

   /**
    */
   public function init() {
     // $this->estado_administrativo_solicitud_id = EstadoAdministrativoSolicitud::model()->findByAttributes(array('nombre'=>'Borrador'))->id;
   }
   
   /**
    */
   public function getTipoSolicitudes() {
      return CHtml::listData(TipoSolicitud::model()->findAll(), 'id', 'nombre');
   }
   
   /**
    */
   public function getCondicionesLote() {
      return CHtml::listData(CondicionLote::model()->findAll(), 'id', 'descripcion');
   }
   
   /**
    */
   public function getTiposVivienda() {
      return CHtml::listData(TipoVivienda::model()->findAll(), 'id', 'descripcion');
   }
   
   /**
    */
   public function getCondicionesDeUso() {
      return CHtml::listData(CondicionUso::model()->findAll(), 'id', 'descripcion');
   }

   /**
    */
   public function rules() {
      return array(
         array('calle', 'required', 'message'=>'Campo obligatorio'),
         array('altura', 'required', 'message'=>'Ingrese una indicacion de altura cualquiera'),
         array('calle, altura, piso, departamento, casa, lote, observaciones,tipo_solicitud_id, condicion_lote_id,'.
               'tipo_vivienda_id, condicion_uso_id, formal, costo_superior, es_alquiler', 'safe', 'on'=>'post'),
      );
   }

   public function attributeLabels() {
      return array(
         'calle' => 'Nombre calle o ruta',
         'altura' => 'Altura, Km de ruta u otra indicacion.',
         'piso' => 'Piso',
         'departamento' => 'Departamento',
         'casa' => 'Numero de casa o puerta',
         'lote' => 'Numero de lote',
         'observaciones' => 'Observaciones generales',
         'tipo_solicitud_id' => 'Tipo de solicitud',
         'condicion_lote_id' => 'Condicion del Lote',
         'tipo_vivienda_id' => 'Tipo de vivienda',
         'condicion_uso_id' => 'Condicion de uso de la vivienda actual',
         'formal' => 'Alquila de manera:',
         'costo_superior' => 'Costo de Alquiler supera la mitad de su ingreso',
      );
   }

}