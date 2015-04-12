<?php
class User extends CActiveRecord {
   
   public function tableName() {
      return 'user';
   }

   public static function model($className=__CLASS__) {
      return parent::model($className);
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      return array(
         array('username, password, nombre, apellido, role', 'required'),
         array('nombre, apellido', 'length', 'max'=> 40),
         array('username', 'length', 'max'=> 20),
         array('password', 'length', 'is'=> 60),
         array('username, password', 'unsafe')
      );
   }

   /**
    * @return array relational rules.
    */
   public function relations() {
      return array();
   }

   public function search() {

      $criteria=new CDbCriteria;

      $criteria->compare('username',$this->apellido,true);
      $criteria->compare('nombre',$this->nombre,true);
      $criteria->compare('apellido',$this->apellido,true);

      return new CActiveDataProvider($this, array(
         'criteria'=>$criteria
      ));
   }

}
