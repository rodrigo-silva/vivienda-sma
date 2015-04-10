<div class="row">
   <h1 class="text-center span10">Solicitud #<?php echo "$model->numero"; ?></h1>
</div>
<div class="row">
   <legend class="span10">Informacion general</legend>
</div>
<div class="row">
   <dl class="dl-horizontal span10">
      <dt>Tipo de solicitud</dt>
      <dd><?php echo $model->tipoSolicitud->nombre ?></dd>
      <dt>Estado</dt>
      <dd>
         <?php $estado = $model->estado->nombre == "Activa" ? 'label-success' : ''?> 
         <span class="label $estado"><?php echo $model->estado->nombre ?></span>
      </dd>
      <dt>Fecha inscripcion</dt>
      <dd><?php echo $model->fecha?></dd>
      <dt>Titular</dt>
      <dd><?php echo $model->titular->nombre . ' ' . $model->titular->apellido ?></dd>
   </dl>
</div>

<?php
// numero INTEGER NOT NULL,
//    fecha DATE NOT NULL,
//    tipo_solicitud_id INTEGER NOT NULL,
//    tipo_vivienda_id INTEGER NOT NULL,
//    condicion_lote_id INTEGER NULL,
//    condicion_uso_id INTEGER NOT NULL,
//    condicion_alquiler_id INTEGER NULL,
//    grupo_conviviente_id INTEGER NOT NULL,
//    titular_id INTEGER NOT NULL,
//    cotitular_id INTEGER NULL,
//    estado_administrativo_solicitud_id INTEGER NOT NULL
?>