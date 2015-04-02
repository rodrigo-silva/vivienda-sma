<?php
/**
 * Formulario para crear una persona
 */
class PersonaForm extends CFormModel {
   public $nombre;
   public $apellido;
   public $dni;
   public $sexo;
   public $fecha_nac;
   public $pais_nac;
   public $provincia_nac;
   public $localidad_nac;
   public $nacionalidad;
   
   public $telefonoFijoPre = 2972;
   public $telefonoFijo;
   public $telefonoCelularPre = 2972;
   public $telefonoCelular;

   public $tipo_situacion_laboral_id;

   public $ingresos_laborales = 0;
   public $ingresos_alimentos = 0;
   public $ingresos_subsidio = 0;

   public $relacion_dependencia = 0;
   public $formal = 0;
   public $ocupacion;

   public $condicionesEspeciales;


   /**
    * Reglas de validacion general
    */
   public function rules() {
      return array(
         array('nombre, apellido, dni, sexo, fecha_nac, pais_nac, provincia_nac, localidad_nac, nacionalidad,' .
                'telefonoFijoPre, telefonoFijo, telefonoCelularPre, telefonoCelular,' .
                'ingresos_laborales, ingresos_alimentos, ingresos_subsidio, relacion_dependencia, formal, ocupacion,' .
                'condicionesEspeciales, tipo_situacion_laboral_id', 'safe'),
         array('nombre, apellido, sexo, fecha_nac, pais_nac, nacionalidad',
               'required', 'message'=> "Campo obligatorio"),
         array('dni, telefonoFijoPre, telefonoFijo, telefonoCelularPre, telefonoCelular,' . 
               'ingresos_laborales, ingresos_alimentos, ingresos_subsidio',
               'numerical', 'integerOnly'=>true, 'allowEmpty'=>true, 'message'=>'Utilice solo numeros.'),
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
         'pais_nac' => 'Pais de nacimiento',
         'provincia_nac' => 'Provincia',
         'localidad_nac' => 'Localidad',
         'nacionalidad' => 'Nacionalidad',
         'telefonoFijo' => 'Telefono Fijo',
         'telefonoCelularPre' => 'Prefijo Celular',
         'telefonoCelular' => 'Celular',
         'formal' => 'De manera formal o registrada',
         'condicionesEspeciales' => 'Condiciones Especiales',
         'relacion_dependencia' => 'Modalidad de trabajo',
         'tipo_situacion_laboral_id' => 'Situacion Laboral Actual'
      );
   }

   /**
    * @Override
    */
   public function beforeValidate() {
      $this->telefonoFijo = str_replace('-', '', $this->telefonoFijo);
      $this->telefonoCelular = str_replace('-', '', $this->telefonoCelular);
      $this->dni = str_replace('.', '', $this->dni);
      
      return parent::beforeValidate();
   }

   /**
    */
   public function getCondicionesEspeciales() {
      return CHtml::listData(CondicionEspecial::model()->findAll(), 'id', 'nombre');
   }

   /**
    */
   public function getSituacionesLaborales() {
      return CHtml::listData(TipoSituacionLaboral::model()->findAll(), 'id', 'descripcion');
   }
}