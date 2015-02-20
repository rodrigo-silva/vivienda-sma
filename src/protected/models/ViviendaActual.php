<?php

/**
 * This is the model class for table "vivienda_actual".
 *
 * The followings are the available columns in table 'vivienda_actual':
 * @property integer $id
 * @property integer $tipo_vivienda_id
 * @property integer $condicion_uso_id
 * @property integer $condicion_alquiler_id
 *
 * The followings are the available model relations:
 * @property Solicitud[] $solicituds
 * @property TipoVivienda $tipoVivienda
 * @property CondicionUso $condicionUso
 * @property CondicionAlquiler $condicionAlquiler
 */
class ViviendaActual extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vivienda_actual';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo_vivienda_id, condicion_uso_id', 'required'),
			array('tipo_vivienda_id, condicion_uso_id, condicion_alquiler_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tipo_vivienda_id, condicion_uso_id, condicion_alquiler_id', 'safe', 'on'=>'search'),
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
			'solicitudes' => array(self::HAS_MANY, 'Solicitud', 'vivienda_actual_id'),
			'tipo' => array(self::BELONGS_TO, 'TipoVivienda', 'tipo_vivienda_id'),
			'condicionUso' => array(self::BELONGS_TO, 'CondicionUso', 'condicion_uso_id'),
			'condicionAlquiler' => array(self::BELONGS_TO, 'CondicionAlquiler', 'condicion_alquiler_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipo_vivienda_id' => 'Tipo Vivienda',
			'condicion_uso_id' => 'Condicion Uso',
			'condicion_alquiler_id' => 'Condicion Alquiler',
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
		$criteria->compare('tipo_vivienda_id',$this->tipo_vivienda_id);
		$criteria->compare('condicion_uso_id',$this->condicion_uso_id);
		$criteria->compare('condicion_alquiler_id',$this->condicion_alquiler_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViviendaActual the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
