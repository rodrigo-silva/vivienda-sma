<?php
class SolicitudBaseForm extends CFormModel {
   //datos de la solicitud
   public $comparte_dormitorio;
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
   public $puerta;
   public $cruce_calle_1;
   public $cruce_calle_2;
   public $manzana;
   public $barrio;
   public $estancia;
   public $lote;
   public $observaciones;

   /**
    */
   public function init() {
     // $this->estado_administrativo_solicitud_id = EstadoAdministrativoSolicitud::model()->findByAttributes(array('nombre'=>'Borrador'))->id;
   }
   
   /**
    */
   public function getTipoSolicitudes($titular) {
      $archivo = SolicitudArchivo::model()->with(array('titular', 'resolucion'))->find(
            'titular.id=:idTit AND resolucion.descripcion=:desc', array('idTit'=>$titular->id, ':desc'=>'Adjudicado') );

      if( empty($archivo) ) {
         return CHtml::listData(TipoSolicitud::model()->findAll(), 'id', 'nombre');
      } else {
         Yii::app()->user->setFlash("general-warning", "El titular tiene una adjudicacion previa, por consiguiente solo puede solicitar ". 
               "Refaccion o Ampliacion.");
         $criteria = new CDbCriteria();
         $criteria->addInCondition("nombre", array("Refaccion", "Ampliacion"));
         return CHtml::listData(TipoSolicitud::model()->findAll($criteria), 'id', 'nombre');
      }
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
         array('calle, altura, piso, departamento, casa,' .
               'puerta, cruce_calle_1, cruce_calle_2, manzana, barrio, estancia, '.
               'lote, observaciones,comparte_dormitorio, tipo_solicitud_id, condicion_lote_id,'.
               'tipo_vivienda_id, condicion_uso_id, formal, costo_superior, es_alquiler', 'safe', 'on'=>'post'),
      );
   }

   public function attributeLabels() {
      return array(
         'calle' => 'Nombre calle o ruta',
         'altura' => 'Altura, Km de ruta u otra indicacion.',
         'piso' => 'Piso',
         'departamento' => 'Departamento',
         'casa' => 'Numero de casa',
         'puerta' => 'Puerta',
         'cruce_calle_1' => 'Interseccion con calle',
         'cruce_calle_2' => 'Interseccion con calle',
         'manzana' => 'Manzana',
         'barrio' => 'Barrio',
         'estancia' => 'Estancia',
         'lote' => 'Numero de lote',
         'observaciones' => 'Observaciones generales',
         'comparte_dormitorio' => 'La pareja comparte dormitorio con otro familiar',
         'tipo_solicitud_id' => 'Tipo de solicitud',
         'condicion_lote_id' => 'Condicion del Lote',
         'tipo_vivienda_id' => 'Tipo de vivienda',
         'condicion_uso_id' => 'Condicion de uso de la vivienda actual',
         'formal' => 'Alquila de manera:',
         'costo_superior' => 'Costo de Alquiler supera la mitad de su ingreso',
      );
   }


   /**
       */
      public function validate() {
         if(parent::validate()) {
            return $this->validateFieldPrescenceCombination();
         } else {
            return false;
         }
      }

      /**
       * Valida la prescencia exclusiva de los campos del form de entrada/busqueda.
       */
      private function validateFieldPrescenceCombination() {
         if ($this->calle == null &&
                  $this->altura == null &&
                  $this->piso == null &&
                  $this->departamento == null &&
                  $this->casa == null &&
                  $this->puerta == null &&
                  $this->cruce_calle_1 == null &&
                  $this->cruce_calle_2 == null &&
                  $this->manzana == null &&
                  $this->barrio == null &&
                  $this->estancia == null &&
                  $this->lote == null) {
            Yii::app()->user->setFlash('general-error', "Indique al menos un campo de los datos de domicilio.");
         return false;
         } else {
            return true;
         }
      }

}