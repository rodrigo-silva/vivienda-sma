<?php
class PersonaManagerTest extends CDbTestCase {
   public $fixtures = array('condicion_especial_fixture'=>'CondicionEspecial');

   public function testSavePersona() {
      $form = new PersonaForm;
      $form->nombre = 'Juan';
      $form->apellido = 'Perez';
      $form->dni = 30123456;
      $form->sexo = 'M';
      $form->fecha_nac = '1950-01-01';
      $form->pais_nac_id = 1;
      $form->provincia_nac_id = 15;
      $form->localidad_nac_id = 7813;
      $form->nacionalidad = 'Argentino';
      $form->trabaja = 0;
      $form->jubilado_pensionado = 0;
      $form->formal = 0;
      $form->ingreso_neto_mensual = 5000;
      $form->condicionesEspeciales = array(1);

      $persona = PersonaManager::savePersona($form);
     
      $persona->delete();

   }
}