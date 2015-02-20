<?php

/**
 * This is the model class for table "solicitud".
 *
 * The followings are the available columns in table 'solicitud':
 * @property integer $id
 * @property integer $numero
 * @property string $fecha
 * @property integer $tipo_solicitud_id
 * @property integer $vivienda_actual_id
 * @property integer $grupo_conviviente_id
 * @property integer $titular_id
 * @property integer $cotitular_id
 *
 * The followings are the available model relations:
 * @property GrupoSolicitante[] $grupoSolicitantes
 * @property TipoSolicitud $tipoSolicitud
 * @property ViviendaActual $viviendaActual
 * @property GrupoConviviente $grupoConviviente
 * @property Persona $titular
 * @property Persona $cotitular
 */
class Solicitud extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'solicitud';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('numero, fecha, tipo_solicitud_id, vivienda_actual_id, grupo_conviviente_id, titular_id, cotitular_id', 'required'),
			array('numero, tipo_solicitud_id, vivienda_actual_id, grupo_conviviente_id, titular_id, cotitular_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, numero, fecha, tipo_solicitud_id, vivienda_actual_id, grupo_conviviente_id, titular_id, cotitular_id', 'safe', 'on'=>'search'),
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
			'solicitantes' => array(self::MANY_MANY, 'Persona', 'grupo_solicitante(solicitud_id, persona_id)'),
			'tipoSolicitud' => array(self::BELONGS_TO, 'TipoSolicitud', 'tipo_solicitud_id'),
			'viviendaActual' => array(self::BELONGS_TO, 'ViviendaActual', 'vivienda_actual_id'),
			'grupoConviviente' => array(self::BELONGS_TO, 'GrupoConviviente', 'grupo_conviviente_id'),
			'titular' => array(self::BELONGS_TO, 'Persona', 'titular_id'),
			'cotitular' => array(self::BELONGS_TO, 'Persona', 'cotitular_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'numero' => 'Numero',
			'fecha' => 'Fecha',
			'tipo_solicitud_id' => 'Tipo Solicitud',
			'vivienda_actual_id' => 'Vivienda Actual',
			'grupo_conviviente_id' => 'Grupo Conviviente',
			'titular_id' => 'Titular',
			'cotitular_id' => 'Cotitular',
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
		$criteria->compare('numero',$this->numero);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('tipo_solicitud_id',$this->tipo_solicitud_id);
		$criteria->compare('vivienda_actual_id',$this->vivienda_actual_id);
		$criteria->compare('grupo_conviviente_id',$this->grupo_conviviente_id);
		$criteria->compare('titular_id',$this->titular_id);
		$criteria->compare('cotitular_id',$this->cotitular_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Solicitud the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
