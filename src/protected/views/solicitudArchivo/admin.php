
<?php $this->widget('bootstrap.widgets.TbGridView', array(
   'id'=>'solicitud-archivo-grid',
   'dataProvider'=>$model->search(),
   'filter'=>$model,
   'columns'=>array(
      'numero',
      'fecha',
      array(
         'class'=>'TbButtonColumn',
         'template' => '{view}',
      ),
   ),
)); ?>

<script type="text/javascript">
</script>