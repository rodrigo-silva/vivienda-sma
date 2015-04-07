
<?php $this->widget('bootstrap.widgets.TbGridView', array(
   'id'=>'solicitud-grid',
   'dataProvider'=>$model->search(),
   'filter'=>$model,
   'columns'=>array(
      'numero',
      'fecha',
      array(
         'class'=>'TbButtonColumn',
         'template' =>"{view}{update}"
      ),
   ),
)); ?>

<script type="text/javascript">
</script>