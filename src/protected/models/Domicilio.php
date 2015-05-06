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
			array('calle, cruce_calle_1, cruce_calle_2, barrio, edificio', 'length', 'max'=>40),
			array('altura', 'length', 'max'=>10),
			array('piso, departamento, casa, lote, puerta, manzana', 'length', 'max'=>3),
			array('observaciones', 'length', 'max'=>250),
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
         'grupoConviviente' => array(self::HAS_ONE, 'GrupoConviviente', 'domicilio_id'),
         'viviendaActual' => array(self::HAS_ONE, 'ViviendaActual', 'domicilio_id')
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
