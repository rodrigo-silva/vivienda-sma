<?php
/**
 * Formulario de una solicitud
 */
class SolicitudForm extends CFormModel {
   
   public $fecha;
   public $tipo_solicitud_id;
   public $condicion_lote_id;
   public $vivienda_actual_id;
   public $grupo_conviviente_id;
   public $titular_id;
   public $cotitular_id;
   public $estado_administrativo_solicitud_id;
   public $grupo_solicitante;

   public function init() {
      $this->estado_administrativo_solicitud_id = EstadoAdministrativoSolicitud::model()->findByAttributes(array('nombre'=>'Borrador'))->id;
   }
}