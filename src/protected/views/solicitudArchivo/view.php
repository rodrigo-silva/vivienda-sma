<div class="row">
   <h2 class="text-center span10"><?php echo "Solicitud #$model->numero"?></h2>
</div>

<div class="row">
   <legend class="span10"></legend>
</div>
<div class="row">
   <div class="span3 offset1">
      <h3 class=<?php echo $model->resolucion->descripcion=='Adjudicado'?"'text-success'":"''" ?>>
         <?php echo strtoupper($model->resolucion->descripcion)?>
      </h3>
   </div>
   <div class="span5">
      <p><?php echo $model->comentarios ?></p>
   </div>
</div>

<div class="row">
   <legend class="span10">Informacion general</legend>
</div>
<div class="row">
   <div class="span4">
      <dl class="dl-horizontal">
         <dt>Tipo de solicitud</dt>
         <dd><?php echo $model->tipoSolicitud->nombre ?></dd>
         <dt>Estado</dt>
         <dd>
            <span class="label label-important">Archivada</span>
         </dd>
         <dt>Fecha inscripcion</dt>
         <dd><?php echo $model->fecha?></dd>
         <dt>Titular</dt>
         <dd><?php echo $model->titular->nombre . ' ' . $model->titular->apellido ?></dd>
         <dt>Cotitular</dt>
         <dd><?php echo $model->cotitular ? $model->cotitular->nombre . ' ' . $model->cotitular->apellido : 'No esta definido' ?></dd>
      </dl>
   </div>
   <div class="span5">
      <dl class="dl-horizontal">
         <dt>Posee Lote</dt>
         <dd><?php echo !strstr($model->tipoSolicitud->nombre, 'ote')? 'Si' : 'No'?></dd>
         <?php if(!strstr($model->tipoSolicitud->nombre, 'ote')):?>
            <dt>Condicion del Lote</dt>
            <dd><?php echo $model->condicionLote->descripcion ?></dd>
         <?php endif ?>
         <dt>Vivienda actual</dt>
         <dd><?php echo $model->tipoVivienda->descripcion ?></dd>
         <dt>Condicion de uso</dt>
         <dd><?php echo $model->condicionUso->descripcion ?></dd>
         <?php if($model->condicionAlquiler):?>
            <dt>Alquiler formal</dt>
            <dd><?php echo $model->condicionAlquiler->formal ? 'Si' : 'No' ?></dd>
            <dt>Costo</dt>
            <dd><?php echo $model->condicionAlquiler->costo_superior ? 'Superior al %50 de su ingreso' :  'Inferior al %50 de su ingreso' ?></dd>
         <?php endif ?>
      </dl>
   </div>
</div>

<div class="row">&nbsp;</div>
<div class="row">
   <legend class="span10">Informacion del domicilio</legend>
</div>
<div class="row">
   <div class="span3 offset1">
      <h4><?php echo $model->domicilio->calle ?> <?php echo $model->domicilio->altura ?></h4>
   </div>
   <div class="span5">
      <dl class="dl-horizontal">
         <dt>Calle</dt>
         <dd><?php echo $model->domicilio->calle ?></dd>
         <dt>Altura/Km</dt>
         <dd><?php echo $model->domicilio->altura ?></dd>
         
         <?php if($model->domicilio->piso): ?>
            <dt>Piso</dt>
            <dd><?php echo $model->domicilio->piso ?></dd>
         <?php endif?>
         <?php if($model->domicilio->departamento): ?>
            <dt>Departamento</dt>
            <dd><?php echo $model->domicilio->departamento ?></dd>
         <?php endif?>
         <?php if($model->domicilio->casa): ?>
            <dt>Casa</dt>
            <dd><?php echo $model->domicilio->casa ?></dd>
         <?php endif?>
         <?php if($model->domicilio->lote): ?>
            <dt>Lote</dt>
            <dd><?php echo $model->domicilio->lote ?></dd>
         <?php endif?>
      </dl>
   </div>
</div>
<?php if($model->domicilio->observaciones): ?>
<div class="row">
   <div class="span6">
      <h5>Observaciones</h5>
   </div>
</div>   
<div class="row">
   <div class="span4 offset1">
      <?php echo $model->domicilio->observaciones ?>
   </div>
</div>   
<?php endif?>

<div class="row">&nbsp;</div>
<div class="row">
   <legend class="span10">Detalles de la vivienda actual</legend>
</div>
<div class="row">
   <div class="offset1 span8">
      <?php if(empty($model->servicios)): ?>
         <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, "El domicilio no posee ningun servicio.", array('closeText'=>'')) ?>
      <?php else: ?>
         <table class="table table-condensed table-hover">
            <thead>
               <tr>
                  <th></th>
                  <th><div class="text-center">Servicio con medidor</div></th>
                  <th><div class="text-center">Es compartido con otro vecino</div></th>
               </tr>
            </thead>
            <tbody>
               <?php foreach($model->servicios as $servicio):?>
                  <tr>
                     <td><?php echo $servicio->tipoServicio->descripcion ?></td>
                     <td><div class="text-center"><?php echo $servicio->medidor?'Si':'No' ?></div></td>
                     <td><div class="text-center"><?php echo $servicio->compartido?'Si':'No' ?></div></td>
                  </tr>
               <?php endforeach?>
            </tbody>
         </table>
      <?php endif?>
   </div>
</div>

<div class="row">
   <div class="span8 offset1">
      <?php if(empty($model->banios)): ?>
         <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, "El domicilio no posee ningun ba&ntild;o.", array('closeText'=>'')) ?>
      <?php else: ?>
         <dl class="dl-vertical">
            <dt>Cantidad de ba&ntilde;os: <?php echo count($model->domicilio->viviendaActual->banios) ?></dt>
            <?php foreach($model->banios as $banio): ?>
               <dd>
                  <?php echo "# " . ($banio->es_letrina?'Letrina': (($banio->interno?"Es interno":"Es externo") . ($banio->completo?" y esta completo":" y esta incompleto"))) ?>
               </dd>
            <?php endforeach?>
         </dl>
      <?php endif?>
   </div>
</div>

<div class="row">&nbsp;</div>
<div class="row">
   <legend class="span10">Detalles del grupo conviviente</legend>
</div>
<div class="row">
   <div class="offset1 span8">
      <table class="table">
         <thead>
            <tr>
               <th><div class="">Nombre completo</div></th>
               <th><div class="text-center">D.N.I.</div></th>
               <th><div class="text-center">Parentezco</div></th>
               <th><div class="text-center">Edad</div></th>
               <th><div class="text-center">Es solicitante</div></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach($model->convivientes as $conviviente):?>
               <?php $persona = $conviviente->persona; ?>
               <?php $esTitular = $persona->id == $model->titular->id ?>
               <tr <?php echo $conviviente->es_solicitante? 'class="success"' : ''?> >
                  <td>
                     <?php echo TbHtml::tooltip("$persona->apellido $persona->nombre " . ($esTitular?TbHtml::icon(TbHtml::ICON_STAR):''),
                            Yii::app()->createUrl('persona/view/' . $persona->id), "Haga click para ver")?>
                  </td>
                  <td><div class="text-center"><?php echo $persona->dni ?></div></td>
                  <td><div class="text-center"><?php echo $persona->id == $model->titular->id ? '' : VinculosUtil::resolveVinculo($persona, $model->titular) ?></div></td>
                  <td><div class="text-center"><?php echo date_diff(date_create($persona->fecha_nac), date_create('today'))->y; ?> a&ntilde;os</div></td>
                  <td>
                     <div class="text-center">
                     <?php echo $conviviente->es_solicitante ? TbHtml::icon(TbHtml::ICON_OK):'' ?>
                     </div>
                  </td>
               </tr>
            <?php endforeach?>
         </tbody>
      </table>
   </div>
</div>
