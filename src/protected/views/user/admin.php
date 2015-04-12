<div id="advice-container"></div>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
   'id'=>'user-grid',
   'dataProvider'=>$model->search(),
   'filter'=>$model,
   'columns'=>array(
      'username',
      'nombre',
      'apellido',
      array(
         'class'=>'TbButtonColumn',
         'template' =>'{update}{delete}{resetPassword}',
         'buttons' =>array(
            'delete' => array('click'=>"js:onDeleteClick"),
            'resetPassword' => array(
               'label' => 'Cambiar password',
               'icon' => TbHtml::ICON_LOCK,
               'url' => '"/user/resetPassword/".$data->id'
            )
         )
      ),
   ),
)); ?>
<script type="text/javascript">
   function onDeleteClick(e) {
      if (!confirm("Desea eliminar este usuario?")){return false;}

      $.post(jQuery(this).attr("href"))
            .done(function(data){
               jQuery("#user-grid").yiiGridView('update');
               var div = jQuery("<div class='alert alert-info'/>");
               var closeBtn = jQuery('<button type="button" class="close" data-dismiss="alert">&times;</button>');
               div.text("Se elimino el usuario exitosamente").append(closeBtn).appendTo(jQuery('#advice-container'))
            })
            .fail(function(data){
               var div = jQuery("<div class='alert alert-error'/>")
               var closeBtn = jQuery('<button type="button" class="close" data-dismiss="alert">&times;</button>');
               div.text(data.responseJSON.error).append(closeBtn).appendTo(jQuery('#advice-container'))
            });
      return false;
   }
</script>