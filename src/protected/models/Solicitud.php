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

   public function init() {
      $this->estado_administrativo_solicitud_id = EstadoAdministrativoSolicitud::model()->findByAttributes(array('nombre'=>'Borrador'))->id;
   }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, numero, tipo_solicitud_id, grupo_conviviente_id, titular_id', 'required'),
			array('tipo_solicitud_id, numero, grupo_conviviente_id, titular_id, cotitular_id', 'numerical', 'integerOnly'=>true),
         array('comparte_dormitorio, tipo_solicitud_id, tipo_vivienda_id, condicion_lote_id, condicion_uso_id,' .
                'grupo_conviviente_id, titular_id', 'safe')
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
         'condicionUso' => array(self::BELONGS_TO, 'CondicionUso', 'condicion_uso_id'),
         'condicionAlquiler' => array(self::BELONGS_TO, 'CondicionAlquiler', 'condicion_alquiler_id'),
			'grupoConviviente' => array(self::BELONGS_TO, 'GrupoConviviente', 'grupo_conviviente_id'),
			'titular' => array(self::BELONGS_TO, 'Persona', 'titular_id'),
			'cotitular' => array(self::BELONGS_TO, 'Persona', 'cotitular_id'),
         'estado' => array(self::BELONGS_TO, 'EstadoAdministrativoSolicitud', 'estado_administrativo_solicitud_id'),
         'domicilio' => array(self::HAS_ONE, 'Domicilio', array('domicilio_id' => 'id'), 'through'=>'grupoConviviente'),
         'condicionLote' => array(self::BELONGS_TO, 'CondicionLote', 'condicion_lote_id'),
         'tipoVivienda' => array(self::BELONGS_TO, 'TipoVivienda', 'tipo_vivienda_id'),
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

		$criteria->compare('numero',$this->numero, true);
		$criteria->compare('fecha',$this->fecha, true);

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
