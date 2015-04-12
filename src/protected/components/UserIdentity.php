<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
	private $id;

   /**
    */
   public function authenticate() {
      $record=User::model()->findByAttributes(array('username'=>$this->username));
      if( $record===null )
         return false;
      if( !CPasswordHelper::verifyPassword($this->password, $record->password) )
         return false;
     
      $this->id = $record->id;
      $this->setState('roles', $record->role);
      
      return true;
   }

   /**
    */
   public function getId(){
     return $this->id;
   }
}