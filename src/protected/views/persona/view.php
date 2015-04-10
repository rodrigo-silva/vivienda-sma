<div class="row">
   <h1 class="text-center span10"><?php echo "$model->nombre $model->apellido"; ?></h1>
</div>
<div class="row">
   <legend class="span10">Datos personales</legend>
</div>
<div class="row">
   <dl class="dl-horizontal span10">
      <dt>DNI</dt>
      <dd><?php echo $model->dni ?></dd>
      <dt>Edad</dt>
      <dd><?php echo date_diff(date_create($model->fecha_nac), date_create('today'))->y . " a&ntilde;os"; ?></dd>
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
<?php if($model->domicilio):?>
<div class="row">
   <legend class="span10">Domicilio Registrado</legend>
</div>
<div class="row">
   <dl class="span10 dl-horizontal">
      <dt>Ubicado en</dt>
      <dd><?php echo $model->domicilio->calle . ' ' . $model->domicilio->altura ?></dd>
   </dl>
</div>
<?php endif?>

<div class="row">
   <legend class="span10">Situacion Economica</legend>
</div>
<div class="row">
   <dl class="dl-horizontal">
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

<?php
// CREATE TABLE situacion_economica (
//    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
//    ingresos_laborales INTEGER NULL,
//    ingresos_alimentos INTEGER NULL,
//    ingresos_subsidio INTEGER NULL,
//    persona_id INTEGER NOT NULL
// ) ENGINE = InnoDB;

// CREATE TABLE situacion_laboral (
//    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
//    relacion_dependencia BIT(1),
//    formal BIT(1),
//    ocupacion VARCHAR(30),
//    situacion_economica_id INTEGER NOT NULL,
//    tipo_situacion_laboral_id INTEGER NOT NULL
// ) ENGINE = InnoDB;
//        'situacionEconomica' => array(self::HAS_ONE, 'SituacionEconomica', 'persona_id'),
//        'vinculos' => array(self::HAS_MANY, 'Vinculo', 'persona_id'),
//        'familiares' => array(self::HAS_MANY, 'Persona', array('familiar_id'=>'id'), 'through'=>'vinculos'),
//        'condicionesEspeciales' => array(self::MANY_MANY, 'CondicionEspecial', 
//                                         'persona_condicion_especial(persona_id, condicion_especial_id)'),
//        'grupoConviviente' => array(self::BELONGS_TO, 'GrupoConviviente', 'grupo_conviviente_id'),
//        'domicilio' => array(self::HAS_ONE, 'Domicilio', array('domicilio_id' => 'id'), 'through'=>'grupoConviviente'),
//        'titularidad' => array(self::HAS_ONE, 'Solicitud', 'titular_id'),
//        'solicitud' => array(self::BELONGS_TO, 'Solicitud', 'solicitud_id'),
//        'cotitularidad' => array(self::HAS_ONE, 'Solicitud', 'cotitular_id'),
//
//   solicitud_id INTEGER NULL,
//   #Nacimiento
//   fecha_nac DATE NOT NULL,
//   pais_nac VARCHAR(20) NOT NULL,
//   provincia_nac VARCHAR(30) NULL,
//   localidad_nac VARCHAR(50) NULL,
//   nacionalidad VARCHAR(20),
//   celular_prefijo INTEGER NULL,
//   telefono_prefijo INTEGER NULL,
//   celular INTEGER NULL,
//   telefono INTEGER NULL,
?>