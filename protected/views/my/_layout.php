<h1 class="fancy"><?php echo CHtml::encode(CHtml::value($model, 'profile.fullname')); ?> <small class="text-primary">(<?php echo CHtml::value($model, 'username'); ?>)</small></h1>
<?php
$this->widget('booster.widgets.TbMenu', array(
    'type' => 'tabs',
    'items' => array(
        array(
            'label' => Yii::t('profile', 'My Profile'),
            'url' => array('my/profile'),
        ),
        array(
            'label' => Yii::t('profile', 'Examination'),
            'url' => array('my/application'),
        ),
        array(
            'label' => Yii::t('profile', 'Certificate'),
            'url' => array('my/certificate'),
        ),
        array(
            'label' => Yii::t('profile', 'Result'),
            'url' => array('my/result'),
        ),
        array(
            'label' => Helper::t('Change Password', 'เปลี่ยนรหัสผ่าน'),
            'url' => array('my/index'),
        ),
        array(
            'label' => Helper::t('View Editing History', 'ประวัติการเปลี่ยนแปลงข้อมูล'),
            'url' => array('my/changeName'),
        ),
    ),
));
?>
<?php echo $content; ?>