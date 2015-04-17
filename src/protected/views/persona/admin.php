<div id="advice-container"></div>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'persona-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		'apellido',
		'dni',
      'telefono' => array('name' => 'telefono', 'value' => '$data->telefono ', 'filter' => false),
      'celular' => array('name' => 'celular', 'value' => '$data->celular_prefijo . " " . $data->celular ', 'filter' => false),
		array(
			'class'=>'TbButtonColumn',
         'template' => Yii::app()->user->checkAccess('writer') ? '{view}{update}{delete}' : '{view}',
         'buttons' =>array(
            'delete' => array('click'=>"js:onDeleteClick"),
         )
		),
	),
)); ?>
<script type="text/javascript">
   function onDeleteClick(e) {
      if (!confirm("Desea eliminar esta persona?")){return false;}

      jQuery.post(jQuery(this).attr("href"))
            .done(function(data){
               jQuery("#persona-grid").yiiGridView('update');
               var div = jQuery("<div class='alert alert-info'/>");
               var closeBtn = jQuery('<button type="button" class="close" data-dismiss="alert">&times;</button>');
               div.text("Se elimino el registro exitosamente").append(closeBtn).appendTo(jQuery('#advice-container'))
            })
            .fail(function(data){
               var div = jQuery("<div class='alert alert-error'/>")
               var closeBtn = jQuery('<button type="button" class="close" data-dismiss="alert">&times;</button>');
               div.text(data.responseJSON.error).append(closeBtn).appendTo(jQuery('#advice-container'))
            });
      return false;
   }
</script>