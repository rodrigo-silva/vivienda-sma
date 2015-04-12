
<?php $this->widget('bootstrap.widgets.TbGridView', array(
   'id'=>'solicitud-grid',
   'dataProvider'=>$model->search(),
   'filter'=>$model,
   'columns'=>array(
      'numero',
      'fecha',
      array(
         'class'=>'TbButtonColumn',
         'template' => Yii::app()->user->checkAccess('writer') ? '{view}{update}{archivar}' : '{view}',
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