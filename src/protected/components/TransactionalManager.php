<?php
abstract class TransactionalManager extends CComponent{
   
   protected static function doInTransaction($transactionalFunction) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
         $result = $transactionalFunction();
         $transaction->commit();   

         return $result;
      } catch (Exception $e) {
         $transaction->rollBack();
         Yii::log("Exception en " . $e->file . " : " . $e->line . ' | ' . $e->message);
         if($e instanceof CHttpException) {
            throw $e;
         }
         throw new CHttpException(500, 'Error interno. Contacte al administrador');
      } 
   }
}