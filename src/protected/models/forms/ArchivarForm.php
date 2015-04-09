<?php
class ArchivarForm extends CFormModel {

   public $tipo_resolucion_id;
   public $comentarios;
   public $numero;

   public function rules() {
      return array(
         array('tipo_resolucion_id, numero', 'required'),
         array('tipo_resolucion_id, comentarios, numero', 'safe'),
         array('comentarios', 'length', 'max'=>250),
      );
   }

   public function attributeLabels() {
      return array(
         'tipo_resolucion_id'=>'Resolucion'
      );
   }

   public function getTiposResolucion() {
      return CHtml::listData(TipoResolucion::model()->findAll(), 'id', 'descripcion');
   }
}