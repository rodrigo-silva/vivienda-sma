<div class="row">
   <legend class="span10">
      Filtrar solicitudes
   </legend>
</div>
<div class="row">
   <div class="offset2">
      <?php echo TbHtml::beginFormTb(TbHtml::FORM_LAYOUT_VERTICAL, Yii::app()->createUrl('solicitud/filtro'), 'get'); ?>
      <div class="row">
         <div class="span7">
            <?php echo TbHtml::activeInlineCheckBoxList($form, 'condiciones', 
                  CHtml::listData(CondicionEspecial::model()->findAll(), 'id', 'nombre'), array("labelOptions" => 
                     array("style"=>"margin-left:10px;")) ); ?>
         </div>
      </div>

      <div class="row">
         <div class="span5">
            <?php echo TbHtml::activeCheckBox($form, 'adulto', array('label' => 'Adulto Mayor')); ?>
         </div>
      </div>
      <div class="row">
         <div class="span5">
            <?php echo TbHtml::activeCheckBox($form, 'menor', array('label' => 'Menor de 18')); ?>
         </div>
      </div>
      <div class="row">
         <div class="offset2 span6">
            <?php echo TbHtml::submitButton('Filtrar');?>
         </div>
      </div>
      
      <?php echo TbHtml::endForm(); ?>
   </div>
</div>
<div class="row">
   <div class="span10">
      <?php $this->widget('bootstrap.widgets.TbGridView', array(
         'id'=>'filtro-grid',
         'dataProvider'=>$dataProvider,
         'columns'=>array(
            'numero',
            array('name'=>'titular_search', 'header' => 'Titular', 'value'=>'$data->titular->nombre . " " . $data->titular->apellido'),
            array('name'=>'fecha', 'value'=>'date("d-m-Y", strtotime($data->fecha))', 'filter'=>false),
            array('name'=>'estado', 'value'=>'$data->estado->nombre', 'filter'=>false),
            array(
               'class'=>'TbButtonColumn',
               'template' => Yii::app()->user->checkAccess('writer') ? '{view}{update}{print}' : '{view}{print}',
               'buttons' => array(
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
   </div>
</div>

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