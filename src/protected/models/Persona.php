<?php

/**
 * This is the model class for table "persona".
 *
 * The followings are the available columns in table 'persona':
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property integer $dni
 * @property string $sexo
 * @property integer $situacion_laboral_id
 *
 * The followings are the available model relations:
 * @property SituacionLaboral $situacionLaboral
 */
class Persona extends CActiveRecord
{
   /**
    * @return string the associated database table name
    */
   public function tableName()
   {
      return 'persona';
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules()
   {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
         array('nombre, apellido', 'required'),
         array('apellido', 'length', 'max'=>40),
         array('dni', 'numerical', 'integerOnly'=>true),
         array('anio_residencia', 'numerical', 'integerOnly'=>true, 'min'=>1900, 'allowEmpty'=>true),
         array('nombre', 'length', 'max'=>60),
         array('sexo', 'length', 'max'=>1),
         array('fecha_nac', 'date', 'format'=>'yyyy-M-d', 'message'=>'Formato invalido'),
         array('nombre, apellido, dni, sexo, fecha_nac, pais_nac, provincia_nac, localidad_nac, nacionalidad,'.
            ' condicionesEspeciales, telefono, telefono_prefijo, celular, celular_prefijo', 'safe')
      );
   }

   /**
    * @return array relational rules.
    */
   public function relations()
   {
      // NOTE: you may need to adjust the relation name and the related
      // class name for the relations automatically generated below.
      return array(
        'situacionEconomica' => array(self::HAS_ONE, 'SituacionEconomica', 'persona_id'),
        'vinculos' => array(self::HAS_MANY, 'Vinculo', 'persona_id'),
        'familiares' => array(self::HAS_MANY, 'Persona', array('familiar_id'=>'id'), 'through'=>'vinculos'),
        'condicionesEspeciales' => array(self::MANY_MANY, 'CondicionEspecial', 
                                         'persona_condicion_especial(persona_id, condicion_especial_id)'),
        'grupoConviviente' => array(self::BELONGS_TO, 'GrupoConviviente', 'grupo_conviviente_id'),
        'domicilio' => array(self::HAS_ONE, 'Domicilio', array('domicilio_id' => 'id'), 'through'=>'grupoConviviente'),
        'titularidad' => array(self::HAS_ONE, 'Solicitud', 'titular_id'),
        'solicitud' => array(self::BELONGS_TO, 'Solicitud', 'solicitud_id'),
        'cotitularidad' => array(self::HAS_ONE, 'Solicitud', 'cotitular_id'),
      );
   }

   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels()
   {
      return array(
         'id' => 'ID',
         'nombre' => 'Nombre',
         'apellido' => 'Apellido',
         'dni' => 'Dni',
         'sexo' => 'Sexo',
         'situacion_laboral_id' => 'Situacion Laboral',
      );
   }

   /**
    * Retrieves a list of models based on the current search/filter conditions.
    *
    * Typical usecase:
    * - Initialize the model fields with values from filter form.
    * - Execute this method to get CActiveDataProvider instance which will filter
    * models according to data in model fields.
    * - Pass data provider to CGridView, CListView or any similar widget.
    *
    * @return CActiveDataProvider the data provider that can return the models
    * based on the search/filter conditions.
    */
   public function search()
   {
      // @todo Please modify the following code to remove attributes that should not be searched.

      $criteria=new CDbCriteria;

      $criteria->compare('id',$this->id);
      $criteria->compare('nombre',$this->nombre,true);
      $criteria->compare('apellido',$this->apellido,true);
      $criteria->compare('dni',$this->dni);
      $criteria->compare('sexo',$this->sexo,true);

      return new CActiveDataProvider($this, array(
         'criteria'=>$criteria
      ));
   }

   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return Persona the static model class
    */
   public static function model($className=__CLASS__)
   {
      return parent::model($className);
   }
}
