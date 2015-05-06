<div class="row">
   <h1 class="text-center span10">
      <?php if( Yii::app()->user->checkAccess('writer') ) {
         echo TbHtml::tooltip("$model->nombre $model->apellido",
            Yii::app()->createUrl('persona/update/' . $model->id), "Haga click para editar");
      } else {
         echo "$model->nombre $model->apellido";
      }
      ?>
   </h1>
</div>
<div class="row">
   <legend class="span10">Datos personales</legend>
</div>
<div class="row">
   <dl class="dl-horizontal span9 offset1">
      <dt>DNI</dt>
      <dd><?php echo $model->dni ?></dd>
      <dt>Edad</dt>
      <dd><?php echo date_diff(date_create($model->fecha_nac), date_create('today'))->y . " a&ntilde;os"; ?></dd>
      <?php if(!is_null($model->anio_residencia)):?>
         <dt>Residente desde:</dt>
         <dd><?php echo $model->anio_residencia?></dd>
      <?php endif ?>
      <dt>Pais de nacimiento</dt>
      <dd><?php echo $model->pais_nac?></dd>
      <dt>Fecha de nacimiento</dt>
      <dd><?php echo $model->fecha_nac?></dd>
      <dt>Lugar</dt>
      <dd><?php echo $model->localidad_nac ?></dd>
      <dd><?php echo $model->provincia_nac ?></dd>
      <dt>Telefonos</dt>
      <dd><?php echo $model->telefono ?></dd>
      <dd><?php echo $model->celular_prefijo . " " . $model->celular ?></dd>
   </dl>
</div>
<?php if(!is_null($model->condicionesEspeciales)):?>
<div class="row">
   <div class="span1"></div>
   <?php foreach($model->condicionesEspeciales as $condicion):?>
      <div class="span1"><span class="label label-warning"><?php echo $condicion->nombre ?></span></div>
   <?php endforeach; ?>
</div>
<?php endif?>
<div class="row">
   <div class="span10">&nbsp;</div>
</div>

<div class="row">
   <legend class="span10">Situacion Economica</legend>
</div>
<div class="row">
   <dl class="span9 offset1 dl-horizontal">
      <dt>Situacion laboral</dt>
      <?php if($model->situacionEconomica->situacionLaboral->tipo->descripcion == 'Ocupado'): ?>
         <dd><span class="label label-success">Ocupado</span></dd>
         <dt>Rel. dependencia</dt>
         <dd><?php echo $model->situacionEconomica->situacionLaboral->relacion_dependencia?'Si':'No' ?></dd>
         <dt>Formal</dt>
         <dd><?php echo $model->situacionEconomica->situacionLaboral->formal?'Si':'No' ?></dd>
         <dt>Ingresos laborales</dt>
         <dd>$ <?php echo $model->situacionEconomica->ingresos_laborales ?>.00</dd>
      <?php else:?>
         <dd><span class="label label-inverse"><?php echo $model->situacionEconomica->situacionLaboral->tipo->descripcion ?></span></dd>
      <?php endif?>
      <?php if($model->situacionEconomica->ingresos_subsidio):?>
         <dt>Ingresos por subsidio</dt>
         <dd>$ <?php echo $model->situacionEconomica->ingresos_subsidio ?>.00</dd>
      <?php endif?>
      <?php if($model->situacionEconomica->ingresos_alimentos):?>
         <dt>Alimentos</dt>
         <dd>$ <?php echo $model->situacionEconomica->ingresos_alimentos ?>.00</dd>
      <?php endif?>
   </dl>
</div>

<?php if($model->domicilio):?>
<div class="row">
   <div class="span10">&nbsp;</div>
</div>
<div class="row">
   <legend class="span10">Domicilio Registrado</legend>
</div>
<div class="row">
   <dl class="span9 offset1 dl-horizontal">
      <dt>Ubicado en</dt>
      <dd><?php echo $model->domicilio->calle . ' ' . $model->domicilio->altura ?></dd>
   </dl>
</div>
<?php endif?>