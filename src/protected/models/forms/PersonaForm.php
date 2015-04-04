<?php
/**
 * Formulario para crear una persona
 */
class PersonaForm extends CFormModel {
   public $persona_id;
   public $nombre;
   public $apellido;
   public $dni;
   public $sexo;
   public $fecha_nac;
   public $pais_nac;
   public $provincia_nac;
   public $localidad_nac;
   public $nacionalidad;
   
   public $celular_prefijo;
   public $telefono_prefijo = 2972;
   public $celular;
   public $telefono;

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
                'celular_prefijo, telefono_prefijo, celular, telefono,' .
                'ingresos_laborales, ingresos_alimentos, ingresos_subsidio, relacion_dependencia, formal, ocupacion,' .
                'condicionesEspeciales, tipo_situacion_laboral_id', 'safe'),
         array('nombre, apellido, dni, sexo, fecha_nac, pais_nac, nacionalidad',
               'required', 'message'=> "Campo obligatorio"),
         array('dni, celular_prefijo, telefono_prefijo, celular, telefono,' . 
               'ingresos_laborales, ingresos_alimentos, ingresos_subsidio',
               'numerical', 'integerOnly'=>true, 'allowEmpty'=>true, 'message'=>'Utilice solo numeros.'),
         array('fecha_nac', 'date', 'format'=>'yyyy-M-d', 'message'=>'Formato invalido'),
         array('dni', 'unique', 'className' => 'Persona', 'attributeName' => 'dni', 'message' => 'DNI existente en base de datos ', 'on'=>'new')
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
         'telefono' => 'Telefono Fijo',
         'celular_prefijo' => 'Prefijo Celular',
         'celular' => 'Celular',
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
      $this->telefono = str_replace('-', '', $this->telefono);
      $this->celular = str_replace('-', '', $this->celular);
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