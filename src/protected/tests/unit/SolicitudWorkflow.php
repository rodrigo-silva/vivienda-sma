<?php
class SolicitudWorkflowTest extends CDbTestCase {
   public $fixtures=array('persona_fixture'=>'Persona');

   public function testNuevaConPersona() {
     $solicitante = Persona::model()->findByAttributes(array('dni' => 28985263));
     $solicitante->save();

     $domicilio = new Domicilio;
     $domicilio->provincia_id = 15;
     $domicilio->localidad_id = 7813;
     $domicilio->save();
     $gc = new GrupoConviviente;
     $gc->domicilio_id = $domicilio->id;
     $gc->save();

     
     $condicionAlquiler = new CondicionAlquiler;
     $condicionAlquiler->formal = 0;
     $condicionAlquiler->costo_superior = 1;
     $condicionAlquiler->save();
     
     $viviendaActual = new ViviendaActual;
     $viviendaActual->tipo_vivienda_id = 1;
     $viviendaActual->condicion_uso_id = 1;
     $viviendaActual->condicion_alquiler_id = $condicionAlquiler->id;
     $viviendaActual->save();

     $solicitud = new solicitud;
     $solicitud->fecha = date("Y-m-d");
     $solicitud->tipo_solicitud_id = 1;
     $solicitud->condicion_lote_id = 1;
     $solicitud->vivienda_actual_id = $viviendaActual->id;
     $solicitud->titular_id = $solicitante->id;
     $solicitud->grupo_conviviente_id = $gc->id;
     

     $solicitud->validate();
     CVarDumper::dump($solicitud->getErrors());
     $solicitud->save();   
     /*
tipo_solicitud_id INTEGER NOT NULL,
   condicion_lote_id INTEGER NULL,
   vivienda_actual_id INTEGER NOT NULL,
   grupo_conviviente_id INTEGER NOT NULL,
   titular_id INTEGER NOT NULL,
   cotitular_id INTEGER NOT NULL,
   estado_administrativo_solicitud_id INTEGER NOT NULL
     */
     
   }
}
?>