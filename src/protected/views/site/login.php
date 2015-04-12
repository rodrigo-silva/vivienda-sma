<div class="row">
   <div class="span4 offset2">
      <?php if(Yii::app()->user->hasFlash('loginError')){
            echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, Yii::app()->user->getFlash('loginError'));
         }
      ?>
   </div>
</div>
<div class="row">
   <div class="span4 offset2">
      <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('layout' => TbHtml::FORM_LAYOUT_HORIZONTAL));?>
      <div class="row">
         <div class="span4">
            <?php echo $form->textFieldControlGroup( $model, 'username', array('placeholder'=> 'Ingrese usuario del sistema',)); ?>
         </div>
      </div>
      <div class="row">
         <div class="span4">
            <?php echo $form->passwordFieldControlGroup( $model, 'login_password', array('placeholder'=> 'password',)); ?>
         </div>
      </div>
      <div class="row">
         <div class="span1 offset3">
            <?php echo TbHtml::submitButton('Ingresar')?>
         </div>
      </div>
      <?php $this->endWidget(); ?>
   </div>
</div>