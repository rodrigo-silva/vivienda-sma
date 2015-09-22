
<?php $this->widget('bootstrap.widgets.TbGridView', array(
   'id'=>'solicitud-archivo-grid',
   'dataProvider'=>$model->search(),
   'filter'=>$model,
   'columns'=>array(
      'numero',
      'fecha',
      array('name'=>'estado_search', 'header' => 'Resolucion', 'value'=>'$data->resolucion->descripcion'),
      array(
         'class'=>'TbButtonColumn',
         'template' => '{view}{update}'
      ),
   ),
)); ?>

<script type="text/javascript">
</script>