<?php $this->beginContent('_layout', array('model' => $account)); ?>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $schedule,
    'attributes' => array(
        array(
            'label' => Helper::t('Test Code', 'ประเภทการสอบ'),
            'name' => 'exam_type_id',
            'value' => $schedule->examType->name,
        ),
        array(
            'label' => Helper::t('Applicants', 'จำนวนผู้สมัคร'),
            'value' => '<span class="text-danger">' . Yii::app()->format->formatNumber($schedule->getCountCurrentSeatPreserved()) . '</span> / ' . Yii::app()->format->formatNumber($schedule->max_quota),
            'type' => 'html',
        ),
        array(
            'label' => Helper::t('Test Fee', 'ค่าธรรมเนียมสอบ'),
            'name' => 'register_fee',
            'type' => 'moneyRoundText',
        ),
    ),
));
?>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $schedule,
    'attributes' => $schedule->getSkillDetailArray(),
));
?>
<hr/>
<div>
    <?php echo Configuration::getKey('web_office_index'); ?>
</div>
<?php $this->endContent(); ?>