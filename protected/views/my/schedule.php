<?php $this->beginContent('_layout', array('model' => $model,)); ?>
<?php

$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'ประเภทการสอบ',
            'name' => 'examScheduleAccount.examSchedule.examType.name',
        ),
        array(
            'label' => Helper::t('Applicants', 'จำนวนผู้สมัคร'),
            'value' => '<span class="text-danger">' . Yii::app()->format->formatNumber($model->examScheduleAccount->examSchedule->getCountSeatPreserved()) . '</span> / ' . Yii::app()->format->formatNumber($model->examScheduleAccount->max_quota),
            'type' => 'html',
        ),
        array(
            'label' => Helper::t('Applicants', 'ค่าธรรมเนียมสอบ'),
            'name' => 'examScheduleAccount.examSchedule.register_fee',
            'type' => 'moneyRoundText',
        ),
    ),
));
?>
<?php $this->endContent(); ?>