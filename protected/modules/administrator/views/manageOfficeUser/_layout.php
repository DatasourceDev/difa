<h1 class="fancy"><?php echo CHtml::value($model, 'profile.fullname'); ?> <small class="text-primary">(<?php echo CHtml::value($model, 'username'); ?>)</small></h1>
<?php
$this->widget('booster.widgets.TbMenu', array(
    'type' => 'tabs',
    'items' => array(
        array(
            'label' => Yii::t('profile', 'My Profile'),
            'url' => array('profile', 'id' => $model->id),
            'active' => $this->action->id === 'profile',
        ),
        array(
            'label' => 'รายละเอียด',
            'url' => array('schedule', 'id' => $model->id),
            'active' => $this->action->id === 'schedule',
        ),
        array(
            'label' => 'สมัครสอบ',
            'url' => array('register', 'id' => $model->id),
            'active' => $this->action->id === 'register',
        ),
        array(
            'label' => 'ผลการสอบ',
            'url' => array('result', 'id' => $model->id),
            'active' => $this->action->id === 'result',
        ),
    ),
));
?>
<?php echo $content; ?>