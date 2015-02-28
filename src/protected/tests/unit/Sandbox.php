<?php
class Sandbox extends CDbTestCase {

   public function amiliar() {
      $vinculo = new Vinculo;
      $u1 = new User;
      $u2 = new User;
      $u1->name = "usuario1";
      $u2->name = "usuario2";

      $u2->save();
      $u1->save();

      $vinculo->persona_id = $u1->id;
      $vinculo->familiar_id = $u2->id;
      $vinculo->relacion = "Padre";
      $vinculo->save();

      $vinculo = new Vinculo;
      $vinculo->persona_id = $u2->id;
      $vinculo->familiar_id = $u1->id;
      $vinculo->relacion = "Hijo";
      $vinculo->save();


      // CVarDumper::dump(User::model()->with("vinculo.de")->findByPk($u1->id)->vinculo[0]->de->name);
      CVarDumper::dump(
         User::model()->findByPk($u1->id)->familiares[0]->vinculo(array("condition"=>'familiar_id=:i', 'params'=>array(':i'=>$u1->id)))[0]->relacion


         );
       CVarDumper::dump(
      User::model()->with('vinculo', 'vinculo.of')->findByPk($u1->id)->vinculo[0]
      );
      

   }

   public function testSaving() {
      $p = new Persona;
      $p->nombre = "pepe";
      $p->apellido = "mujica";
      $p->dni = 28985263;
      $p->sexo = "M";
      $p->fecha_nac = date("Y-m-d");
      $p->pais_nac_id = 1;
      $p->provincia_nac_id = 15;
      $p->localidad_nac_id = 7813;
      $p->nacionalidad = "Argentino";

      $p->save();
   }
}