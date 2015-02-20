<?php

/**
* This is the model class for table "domicilio".
*
* The followings are the available columns in table 'domicilio':
* @property integer $id
* @property string $calle
* @property string $altura
* @property string $piso
* @property string $departamento
* @property string $casa
* @property string $lote
* @property string $observaciones
* @property integer $provincia_id
* @property integer $localidad_id
*/
class Domicilio extends CActiveRecord
{
  /**
   * @return string the associated database table name
   */
  public function tableName()
  {
     return 'domicilio';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
     return array(
      array('provincia_id, localidad_id', 'required'),
       array('provincia_id, localidad_id', 'numerical', 'integerOnly'=>true),
       array('calle', 'length', 'max'=>40),
       array('altura', 'length', 'max'=>10),
       array('piso, departamento, casa, lote', 'length', 'max'=>3),
       array('observaciones', 'length', 'max'=>250),
       );
  }

  /**
   * @return array relational rules.
   */
  public function relations()
  {
     return array(
       'provincia' => array(self::BELONGS_TO, 'Provincia', 'provincia_id'),
       'localidad' => array(self::BELONGS_TO, 'Localidad', 'localidad_id'),
       );

  }



  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
     return array(
       'id' => 'ID',
       'calle' => 'Calle',
       'altura' => 'Altura',
       'piso' => 'Piso',
       'departamento' => 'Departamento',
       'casa' => 'Casa',
       'lote' => 'Lote',
       'observaciones' => 'Observaciones',
       'provincia_id' => 'Provincia',
       'localidad_id' => 'Localidad',
       );
  }


  /**
   * Returns the static model of the specified AR class.
   * Please note that you should have this exact method in all your CActiveRecord descendants!
   * @param string $className active record class name.
   * @return Domicilio the static model class
   */
  public static function model($className=__CLASS__)
  {
     return parent::model($className);
  }
}
