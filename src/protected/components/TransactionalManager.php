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
         Yii::log("Exception en " . $e->getFile() . " : " . $e->getLine() . ' | ' . $e->getMessage());
         if($e instanceof CHttpException) {
            throw $e;
         }
         throw new CHttpException(500, 'Error interno. Contacte al administrador');
      } 
   }

   /**
    * Logs error level message containing 'errors' from each model
    */
   public static function logModelErrors($models) {
      $message = "Model errors:";
      foreach ($models as $model) {
         $message = $message . " ". print_r($model->errors, true);
      }
      Yii::log($message, 'error');
   }
}