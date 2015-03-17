<?php
/**
 * Formulario para crear una persona
 */
class PersonaForm extends CFormModel {
   public $formID = 'alta_persona';

   public $nombre;
   public $apellido;
   public $dni;
   public $sexo;
   public $fecha_nac;
   public $pais_nac_id;
   public $provincia_nac_id;
   public $localidad_nac_id;
   public $nacionalidad;
   
   public $telefonoFijoPre = 2972;
   public $telefonoFijo;
   public $telefonoCelularPre = 2972;
   public $telefonoCelular;

   public $trabaja;
   public $jubilado_pensionado;
   public $formal;
   public $ingreso_neto_mensual;

   public $condicionesEspeciales;


   /**
    * Reglas de validacion general
    */
   public function rules() {
      return array(
         array('nombre, apellido, dni, sexo, fecha_nac, pais_nac_id, provincia_nac_id, localidad_nac_id, nacionalidad, telefonoFijoPre, telefonoFijo, telefonoCelularPre, telefonoCelular, trabaja, jubilado_pensionado, formal, ingreso_neto_mensual, condicionesEspeciales', 'safe'),
         array('nombre, apellido, sexo, fecha_nac, pais_nac_id, provincia_nac_id, localidad_nac_id, nacionalidad',
               'required', 'message'=> "Campo obligatorio"),
         array('dni, telefonoFijoPre, telefonoFijo, telefonoCelularPre, telefonoCelular, ingreso_neto_mensual', 'numerical',
               'integerOnly'=>true, 'allowEmpty'=>true, 'message'=>'Utilice solo numeros.'),
         array('fecha_nac', 'date', 'format'=>'yyyy-M-d', 'message'=>'Formato invalido')
      );
   }

   /**
    * Etiquetas de los campos.
    */
   public function attributeLabels() {
      return array(
         'dni' => 'D.N.I.',
         'nombre' => 'Nombre/s',
         'apellido' => 'Apellido/s',
         'sexo' => 'Sexo',
         'fecha_nac' => 'Fecha de nacimiento',
         'pais_nac_id' => 'Pais',
         'provincia_nac_id' => 'Provincia',
         'localidad_nac_id' => 'Localidad',
         'nacionalidad' => 'Nacionalidad',
         'telefonoFijoPre' => 'Prefijo',
         'telefonoFijo' => 'Telefono Fijo',
         'telefonoCelularPre' => 'Prefijo',
         'telefonoCelular' => 'Celular',
         'trabaja' => 'Trabaja',
         'jubilado_pensionado' => 'Es jubilado o Pensionado',
         'formal' => 'De maner formal',
         'ingreso_neto_mensual' => 'Ingresos netos mensuales',
         'condicionesEspeciales' => 'Condiciones Especiales',
      );
   }

   /**
    * @Override
    */
   public function validate() {
      $this->telefonoFijo = str_replace('-', '', $this->telefonoFijo);
      $this->telefonoCelular = str_replace('-', '', $this->telefonoCelular);
      $this->dni = str_replace('.', '', $this->dni);
      return parent::validate();
   }

   /**
    */
   public function getPaises() {
      return CHtml::listData(Pais::model()->findAll(), 'id', 'nombre');
   }

   /**
    */
   public function getProvincias() {
      return CHtml::listData(Provincia::model()->findAll(), 'id', 'nombre');
   }

   /**
    */
   public function getLocalidades() {
      return CHtml::listData(Localidad::model()->findAll(), 'id', 'nombre');
   }

   /**
    */
   public function getCondicionesEspeciales() {
      return CHtml::listData(CondicionEspecial::model()->findAll(), 'id', 'nombre');
   }
}