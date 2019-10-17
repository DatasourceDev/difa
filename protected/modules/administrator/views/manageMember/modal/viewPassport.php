<?php
$this->beginContent('/layouts/modal', array(
    'title' => 'ข้อมูล Passport ของ <span class="text-primary">' . CHtml::value($model, 'profile.fullname') . '</span>',
));
?>
<h4>หมายเลขหนังสือเดินทาง : <span class="text-primary"><?php echo CHtml::value($model, 'profile.passport_no'); ?></span></h4>
<?php echo CHtml::image(CHtml::value($model, 'profile.photoUrl'), '', array('width' => '100%')); ?>
<?php $this->endContent(); ?>