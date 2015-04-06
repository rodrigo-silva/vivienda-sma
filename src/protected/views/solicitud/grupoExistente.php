<?php
echo TbHtml::heroUnit('Informacion existente',<<<EOD
Se ha encontrado informacion prexistente el sistema en referencia al domicilio $domicilio->calle $domicilio->altura. Los datos
incluirian informacion acerca de quienes habitan el domicilio, datos de servicios y estado general de la vivienda. Esto se debe
a que existe uno o mas solicitudes referidas a este domicilio.
Si usted no ha ingresado datos del domicilio, es posible que alguien haya declarado a $titular->nombre $titular->apellido como 
persona conviviente en este domicilio, en otra solicitud.
Usted puede, o bien utilizar estos datos prexistentes o desvincular a $titular->nombre $titular->apellido de este domicilio y 
generar asi una solicitud completamente nueva.
EOD
 ); ?>
<?php echo TbHtml::button('Desvincular', array('color' =>TbHtml::BUTTON_COLOR_WARNING, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'id'=>'desvincular-btn'));?>
<?php echo TbHtml::button('Utilizar datos', array('color' =>TbHtml::BUTTON_COLOR_DANGER, 'size' => TbHtml::BUTTON_SIZE_LARGE, 'id'=>'continuar-btn'));?>
<form action="" class="hide" method="POST">
   <input type="hidden" name="desvincular">
</form>
<script type="text/javascript">
   jQuery("#desvincular-btn").click(function(){jQuery("input[name=desvincular]").val(1); jQuery("form").submit()})
   jQuery("#continuar-btn").click(function(){jQuery("input[name=desvincular]").val(0); jQuery("form").submit()})
</script>