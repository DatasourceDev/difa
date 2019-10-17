<?php $this->beginContent('/layouts/modal', array('title' => Yii::t('app', 'Map'))); ?>
<?php if ($type === 'th'): ?>
    <?php echo CHtml::link(CHtml::image(CHtml::value($model, 'examSchedule.codePlace.placeFile.fileUrl')), '#', array('class' => 'thumbnail')); ?>
<?php else: ?>
    <?php echo CHtml::link(CHtml::image(CHtml::value($model, 'examSchedule.codePlace.placeEnFile.fileUrl')), '#', array('class' => 'thumbnail')); ?>
<?php endif; ?>
<?php $this->endContent(); ?>