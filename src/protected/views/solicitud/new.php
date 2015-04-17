<div class="row">
   <legend class="span10">
      Busqueda persona en sistema
   </legend>
</div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); $form->helpType = TbHtml::HELP_TYPE_INLINE;?>
<div class="row">
   <div class="span8 offset1">
      <?php echo $form->errorSummary($model, ''); ?>
      <?php if(Yii::app()->user->hasFlash('sessionError')){
            echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, Yii::app()->user->getFlash('sessionError'));
          }
      ?>
      <?php if(Yii::app()->user->hasFlash('warning')){
            echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, Yii::app()->user->getFlash('warning'));
          }
      ?>
   </div>
</div>

<div class="row">
   <div class="span8 offset1">
      <?php echo TbHtml::icon(TbHtml::ICON_INFO_SIGN); ?> Puede buscar por DNI o por Nombre/Apellido
   </div>
</div>
<div class="row">
   <div class="span8 offset1">
      <div class="well">
         <div class="row">
            <?php echo $form->textFieldControlGroup( $model, 'dni', array('groupOptions'=>array('class'=>'span4'),
                  'help' => " o bien ") ) ?>
         </div>
         <div class="row">
            <?php echo $form->textFieldControlGroup( $model, 'nombre', array('groupOptions'=>array('class'=>'span3')) ); ?>
            <?php echo $form->textFieldControlGroup( $model, 'apellido', array('groupOptions'=>array('class'=>'span3')) ); ?>
         </div>

         <div class="row">
            <div class="offset6">
               <?php echo TbHtml::submitButton('Siguiente'); ?>
            </div>
         </div>
      </div>
   </div>
</div>



<?php $this->endWidget(); ?>