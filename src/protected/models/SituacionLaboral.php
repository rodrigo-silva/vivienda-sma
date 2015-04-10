<?php

/**
 * This is the model class for table "situacion_laboral".
 *
 * The followings are the available columns in table 'situacion_laboral':
 * @property integer $id
 * @property integer $trabaja
 * @property integer $jubilado_pensionado
 * @property integer $formal
 * @property integer $persona_id
 *
 * The followings are the available model relations:
 * @property Persona $persona
 */
class SituacionLaboral extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'situacion_laboral';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('relacion_dependencia, formal, ocupacion, tipo_situacion_laboral_id', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        
        return array(
            'situacionEconomica' => array(self::BELONGS_TO, 'SituacionEconomica', 'situacion_economica_id'),
            'tipo' => array(self::BELONGS_TO, 'TipoSituacionLaboral', 'tipo_situacion_laboral_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'trabaja' => 'Trabaja',
            'jubilado_pensionado' => 'Jubilado Pensionado',
            'formal' => 'Formal',
            'persona_id' => 'Persona',
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
        $criteria->compare('trabaja',$this->trabaja);
        $criteria->compare('jubilado_pensionado',$this->jubilado_pensionado);
        $criteria->compare('formal',$this->formal);
        $criteria->compare('persona_id',$this->persona_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SituacionLaboral the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}