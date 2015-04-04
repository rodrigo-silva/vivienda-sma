<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'persona-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		'apellido',
		'dni',
		array(
			'class'=>'CButtonColumn',
         // 'afterDelete'=>'function(link,success,data){ if(!success) alert("Delete completed successfully"); }'
         'buttons' =>array(
            'delete' => array('click'=>"js:miFun")
         )
		),
	),
)); ?>
<script type="text/javascript">
   function miFun() {
      console.dir(jQuery(this))
      jQuery("#persona-grid").yiiGridView('update')
      return false;
   }
</script>