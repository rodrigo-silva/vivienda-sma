<?php

class VinculosUtil extends CComponent {
   private static $vinculosMasculinos = array(
                                  'Abuela'=>'Nieto',
                                  'Madre'=>'Hijo',
                                  'Hermana'=>'Hermano',
                                  'Hija'=>'Padre',
                                  'Nieta'=>'Abuelo',
                                  'Prima'=>'Primo',
                                  // 'Cuñada'=>'Cuñado',
                                  'Abuelo'=>'Nieto',
                                  'Padre'=>'Hijo',
                                  'Hermano'=>'Hermano',
                                  'Hijo'=>'Padre',
                                  'Nieto'=>'Abuelo',
                                  'Primo'=>'Primo',
                                  // 'Cuñado'=>'Cuñado',
                                  'Conyuge'=>'Conyuge',
                                  'Sin vinculo' => 'Sin vinculo');
   
   private static $vinculosFemeninos = array(
                                  'Abuela'=>'Nieta',
                                  'Madre'=>'Hija',
                                  'Hermana'=>'Hermana',
                                  'Hija'=>'Madre',
                                  'Nieta'=>'Abuela',
                                  'Prima'=>'Prima',
                                  // 'Cuñada'=>'Cuñada',
                                  'Abuelo'=>'Nieta',
                                  'Padre'=>'Hija',
                                  'Hermano'=>'Hermana',
                                  'Hijo'=>'Madre',
                                  'Nieto'=>'Abuela',
                                  'Primo'=>'Prima',
                                  // 'Cuñado'=>'Cuñada',
                                  'Conyuge'=>'Conyuge',
                                  'Sin vinculo' => 'Sin vinculo');


   /**
    * Devuelve un array simple con lista de vinculos para un masculino
    */
   public static function getVinculosMasculinos() {
      return array_values(array_unique(self::$vinculosMasculinos));
   }

   /**
    * Devuelve un array simple con lista de vinculos para un Femenino
    */
   public static function getVinculosFemeninos() {
       return array_values(array_unique(self::$vinculosFemeninos));
   }

   /**
    * Dado un valor de vinculo, ej 'Madre' devuelve el retrogrado, 'Hijo'
    */
   public static function getVinculoMasculinoRetrogrado($vinculo) {
      return self::$vinculosMasculinos($vinculo);
   }

   /**
    * Dado un valor de vinculo, ej 'Padre' devuelve el retrogrado, 'Hija'
    */
   public static function getVinculoFemeninoRetrogrado($vinculo) {
     return self::$vinculosFemeninos($vinculo);  
   }

}