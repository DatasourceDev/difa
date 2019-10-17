<h1 class="fancy">
    <?php if (!$model->isEnable): ?>
        <small class="glyphicon glyphicon-remove text-danger"></small>
    <?php endif; ?>
    <?php echo CHtml::encode(CHtml::value($model, 'profile.fullname')); ?> 
    <small class="text-primary">(<?php echo CHtml::value($model, 'username'); ?>)</small>
</h1>
<?php
$this->widget('booster.widgets.TbMenu', array(
    'type' => 'tabs',
    'items' => array(
        array(
            'label' => Helper::t('My Profile', 'ข้อมูลส่วนตัว'),
            'url' => array('profile', 'id' => $model->id),
            'active' => $this->action->id === 'profile',
        ),
        array(
            'label' => Yii::t('profile', 'Examination'),
            'url' => array('application', 'id' => $model->id),
            'active' => $this->action->id === 'application',
        ),
        array(
            'label' => Yii::t('profile', 'Certificate'),
            'url' => array('certificate', 'id' => $model->id),
            'active' => $this->action->id === 'certificate',
        ),
        array(
            'label' => Helper::t('Change Password', 'เปลี่ยนรหัสผ่าน'),
            'url' => array('view', 'id' => $model->id),
            'active' => $this->action->id === 'view',
        ),
        array(
            'label' => Helper::t('View Editing History', 'ประวัติการเปลี่ยนแปลงข้อมูล'),
            'url' => array('changeName', 'id' => $model->id),
            'active' => $this->action->id === 'changeName',
        ),
        array(
            'label' => Helper::t('Change Memeber Type', 'เปลี่ยนประเภทสมาชิก'),
            'url' => array('changeType', 'id' => $model->id),
            'active' => $this->action->id === 'changeType',
        ),
        array(
            'label' => Helper::t('Account Setting', 'สถานะบัญชี'),
            'url' => array('setting', 'id' => $model->id),
            'active' => $this->action->id === 'setting',
        ),
    ),
));
?>
<?php echo $content; ?>