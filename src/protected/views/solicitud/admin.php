
<?php $this->widget('bootstrap.widgets.TbGridView', array(
   'id'=>'solicitud-grid',
   'dataProvider'=>$model->search(),
   'filter'=>$model,
   'columns'=>array(
      'numero',
      array('name'=>'titular', 'value'=>'$data->titular->nombre . " " . $data->titular->apellido'),
      array('name'=>'fecha', 'value'=>'date("d-m-Y", strtotime($data->fecha))', 'filter'=>false),
      array('name'=>'estado', 'value'=>'$data->estado->nombre', 'filter'=>false),
      array(
         'class'=>'TbButtonColumn',
         'template' => Yii::app()->user->checkAccess('writer') ? '{view}{update}{archivar}{print}' : '{view}{print}',
         'buttons' => array(
            'archivar' => array(
               'label' => 'Archivar',
               'icon' => TbHtml::ICON_FILE,
               'url' => '"/solicitud/archivar/".$data->numero'
            ),
            'print' => array(
               'label' => 'Imprimir',
               'icon' => TbHtml::ICON_PRINT,
               'url' => '"/solicitud/print/" . $data->id',
               'click' => 'js:print'
            )
         )
      ),
   ),
)); ?>

<script type="text/javascript">
   function print() {
      var newWin = window.open();
      jQuery.get(jQuery(this).attr("href"))
         .done(function(data){
            newWin.document.write(data);
            newWin.document.close();
            newWin.focus();
            newWin.print();
            newWin.close();
         });
      return false;
   }
</script>