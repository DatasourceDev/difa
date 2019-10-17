<div class="topic">สมัครสอบสำหรับหน่วยงาน รอบสอบ <span class="text-primary"><?php echo CHtml::value($this->schedule, 'exam_code'); ?></span></div>
    <?php
    $this->widget('booster.widgets.TbMenu', array(
        'type' => 'tabs',
        'items' => array(
            array(
                'label' => Yii::t('profile', 'My Profile'),
                'url' => array('profile'),
                'active' => $this->action->id === 'profile',
            ),
            array(
                'label' => 'รายละเอียด',
                'url' => array('index', 'id' => $this->schedule->id),
                'active' => $this->action->id === 'index',
            ),
            array(
                'label' => 'สมัครสอบ (' . ($this->countCurrent) . '/' . CHtml::value($this, 'scheduleAccount.preserved_quota') . ')',
                'url' => array('register', 'id' => $this->schedule->id),
                'active' => $this->action->id === 'register',
            ),
            array(
                'label' => 'ผลการสอบ',
                'url' => array('result'),
                'active' => $this->action->id === 'result',
            ),
        ),
    ));
    ?>
<br/>
<?php echo $content; ?>