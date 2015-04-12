<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
   <?php if(Yii::app()->user->hasFlash('general-error')):?>
      <div class="span10 offset1">      
         <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, Yii::app()->user->getFlash('general-error'))?>
      </div>   
   <?php endif?>
   <?php if(Yii::app()->user->hasFlash('general-info')):?>
      <div class="span10 offset1">      
         <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_INFO, Yii::app()->user->getFlash('general-info'))?>
      </div>   
   <?php endif?>
   <?php if(Yii::app()->user->hasFlash('general-success')):?>
      <div class="span10 offset1">      
         <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('general-success'))?>
      </div>   
   <?php endif?>
   <?php if(Yii::app()->user->hasFlash('general-warning')):?>
      <div class="span10 offset1">      
         <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, Yii::app()->user->getFlash('general-warning'))?>
      </div>   
   <?php endif?>
</div>
<div id="content" class="row">
   <div class="span10 offset1">
	  <?php echo $content; ?>
   </div>
</div><!-- content -->
<?php $this->endContent(); ?>