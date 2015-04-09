
<?php $this->widget('bootstrap.widgets.TbGridView', array(
   'id'=>'solicitud-grid',
   'dataProvider'=>$model->search(),
   'filter'=>$model,
   'columns'=>array(
      'numero',
      'fecha',
      array(
         'class'=>'TbButtonColumn',
         'template' =>"{view}{update}{archivar}",
         'buttons' => array(
            'archivar' => array(
               'label' => 'Archivar',
               'icon' => TbHtml::ICON_FILE,
               'url' => '"/solicitud/archivar/".$data->numero'
            )
         )
      ),
   ),
)); ?>

<script type="text/javascript">
</script>