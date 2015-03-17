    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

    <?php echo $form->errorSummary($model, ''); ?>
    <?php if(Yii::app()->user->hasFlash('sessionError')){
            echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, Yii::app()->user->getFlash('sessionError'));
          }
    ?>
    
    <?php echo $form->textFieldControlGroup($model, 'dni'); ?>
    <?php echo $form->textFieldControlGroup($model, 'nombre'); ?>
    <?php echo $form->textFieldControlGroup($model, 'apellido'); ?>
    
    <?php echo TbHtml::submitButton('Siguiente'); ?>
    <?php $this->endWidget(); ?>