<?php
echo TbHtml::heroUnit('Informacion existente',<<<EOD
Se ha encontrado <strong>informacion prexistente</strong> el sistema en referencia al domicilio <strong>$domicilio->calle $domicilio->altura</strong>.
Los datos
incluirian informacion acerca de quienes habitan el domicilio, datos de servicios y estado general de la vivienda. Esto se debe
a que existe uno o mas solicitudes referidas a este domicilio.
<u>Si usted no ha ingresado datos del domicilio</u>, es posible que alguien haya declarado a <strong>$titular->nombre $titular->apellido</strong> como 
persona conviviente en este domicilio, en otra solicitud.
Usted puede, o bien utilizar estos datos prexistentes o desvincular a <strong>$titular->nombre $titular->apellido</strong> de este domicilio y 
generar asi una solicitud completamente nueva.
EOD
 ); ?>
<div class="row">
   <div class="span4 offset3">
      <?php echo TbHtml::button("Desvincular / Cambiar domicilio", array('color' =>TbHtml::BUTTON_COLOR_WARNING,
                                 'size' => TbHtml::BUTTON_SIZE_LARGE, 'id'=>'desvincular-btn'));?>
   </div>
   <div class="span3">
      <?php echo TbHtml::button('Utilizar datos', array('color' =>TbHtml::BUTTON_COLOR_DANGER, 'size' => TbHtml::BUTTON_SIZE_LARGE,
            'id'=>'continuar-btn'));?>
   </div>
</div>



<form action="" class="hide" method="POST">
   <input type="hidden" name="desvincular">
</form>
<script type="text/javascript">
   jQuery("#desvincular-btn").click(function(){jQuery("input[name=desvincular]").val(1); jQuery("form").submit()})
   jQuery("#continuar-btn").click(function(){jQuery("input[name=desvincular]").val(0); jQuery("form").submit()})
</script>