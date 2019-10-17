<?php $this->beginContent('/layouts/modal', array('title' => Yii::t('app', 'Map'))); ?>
<?php echo CHtml::link(CHtml::image(CHtml::value($model, 'examSchedule.codePlace.fileUrl')), '#', array('class' => 'thumbnail')); ?>
<?php $this->endContent(); ?>